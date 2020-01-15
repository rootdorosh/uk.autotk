<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use App\Modules\Auto\Models\{
    Make,
    Model,
    ModelYear,
    Market,
    Engine,
    Generation,
    ThreadSize,
    Trim,
    Wheel,
    TrimWheel,
    BoltPattern
};
use App\Services\Curl;
use HeadlessChromium\BrowserFactory;
use App\Services\Parser\Tire as ParserTire;
use App\Services\Parser\Rim as ParserRim;
use App\Jobs\ModelYearParserPageJob;


class AutoImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto import from sitemap xml';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public static function handle()
    {
        //dd(file_get_contents('https://automobile-assets.s3.amazonaws.com/automobile/body/cadillac-escalade_2015.png'));
        
        $domain = 'https://www.wheel-size.com';
        $autoIdFile = public_path() . '/auto_id.txt';
		
        $data = Curl::getPage($domain . '/size/');
        $pattern = '/<a itemprop="itemListElement" title="(.*?)" href="\/size\/(.*?)\/"><i class="brand-(.*?)"><\/i>(.*?)<\/a>/';
        preg_match_all($pattern, $data, $matches);
        
        if (empty($matches[0])) {
            dd('MAKE_ERROR');
        }
        
		//$autoIdContent = is_file($autoIdFile) ? file_get_contents($autoIdFile) : '0:0:0';
		$autoIdContent = '0:0:0';
		list($makeIdFrom, $modelIdFrom, $modelYearIdFrom) = explode(':', $autoIdContent);
		
        foreach ($matches[0] as $i => $item) {
            $make = self::getMake([
                'slug' => trim($matches[3][$i]),
                'title' => trim($matches[4][$i]),
            ]);
            if (!$make->is_active || $make->id < $makeIdFrom) {
                continue;
            }
            
            echo $make->slug . "\n";
            
            $dataModel = Curl::getPage($domain . '/size/' . $make->slug . '/');
            $patternModel = '/<a itemprop="itemListElement" title="(.*?)" href="\/size\/(.*?)\/(.*?)\/">(.*?)<\/a>/';
            preg_match_all($patternModel, $dataModel, $matchesModel);
            if (empty($matchesModel[0])) {
                dd('MODEL_ERROR');
            }
            
            foreach ($matchesModel[0] as $i => $itemModel) {
                $model = self::getModel([
                    'make_id' => $make->id,
                    'slug' => trim($matchesModel[3][$i]),
                    'title' => trim($matchesModel[4][$i]),
                ]);
				if ($model->id < $modelIdFrom) {
					continue;
				}
				
                echo "\t" . $model->slug . "\n";
                
                preg_match_all(
                    '/<a itemprop="itemListElement" title="(.*?)" href="\/size\/' . $make->slug . '\/'.$model->slug.'\/(.*?)\/">(.*?)<\/a>/',
                    Curl::getPage($domain . '/size/' . $make->slug . '/' . $model->slug . '/'),
                    $matchesModelYear
                );
                
                foreach ($matchesModelYear[0] as $i => $itemModelYear) {
                    $year = (int)$matchesModelYear[3][$i];
                    if ($year < 2010) {
                        continue;
                    }
                    
                    echo "\t\t" . $year . "\n";
                    $url = $domain . '/size/' . $make->slug . '/' . $model->slug . '/' . $year . '/';
                    $yearContent = Curl::getPage($url);
                    $html = \phpQuery::newDocument($yearContent);
                    $imgYear = (string)$html->find('.car-makes-image img')->attr('src');
                        
                    $modelYear = self::getModelYear([
                        'model_id' => $model->id,
                        'year' => $year,
                        'img_title' => $make->slug . '-' . $model->slug . '-' . $year,
                        'img_url' => !empty($imgYear) ? $imgYear : null,
                    ]);
					if ($modelYear->id < $modelYearIdFrom) {
						continue;
					}
                    
					$autoId = "{$make->id}:{$model->id}:{$modelYear->id}";
					
                    $fileOk = public_path() . "/parser-ok/{$modelYear->id}.html";
                    
                    if (is_file($fileOk)) {
                        continue;
                    }
                    
                    dispatch(new ModelYearParserPageJob([
                        'url' => $url,
                        'model_year_id' => $modelYear->id,
                    ]));
                    echo "\t\t $url \n";
                    continue;
                    
					
                    $file = "/parser/{$modelYear->id}.html";
                    
                    preg_match( "/sRwd\=\'\/data\/js\/(.*?)\/'/", $yearContent, $matchCode);
                    if (!isset($matchCode[1])) {
                        dd('sRwd no match');
                    }
                    
                    $code = Curl::getPage('https://www.wheel-size.com/data/js/' . $matchCode[1] . '/');
					
                    $body = $html->find('#vehicle-market-data')->html();
                    file_put_contents(public_path() . $file, (string)view('parser.year', compact('code', 'body')));
                    
                    $browserFactory = new BrowserFactory();
                    $browser = $browserFactory->createBrowser();
                    $page = $browser->createPage();
                    $page->navigate('http://uk.autotk.loc' . $file)->waitForNavigation(\HeadlessChromium\Page::LOAD, 1000000);
                    $evaluation = $page->evaluate('document.documentElement.innerHTML');
                    $content = self::clean($evaluation->getReturnValue());
                    $html = \phpQuery::newDocument('<html>' . $content . '</html>');
                        
                    $content = str_replace(['â€“', 'Â'], '', $html->html());
                    file_put_contents($fileOk, $content);
                    file_put_contents($autoIdFile, $autoid);
                    continue;
                    
                    $html = \phpQuery::newDocument('<html>' . file_get_contents($fileOk) . '</html>');
                    
					
                    foreach ($html->find('.modification-item') as $modificationItem) {
                        $item = pq($modificationItem);
                        
                        $trimAttrs = [
                            'model_year_id' => $modelYear->id,
                            'title' => self::clean($item->find('.same-tag-cloud .dark')->text()),
                        ];
                        
                        foreach ($item->find('.element-parameter') as $elemParam) {
                            $elemParam = pq($elemParam);
                            $paramName = self::clean($elemParam->find('.parameter-name')->text());
                            $paramContent = $elemParam->html();
                           
                            if ($paramName === 'Generation') {                                
                                $expl = explode('<span class="parameter-name">Generation</span>:', $paramContent);
                                $d_slug = self::clean(explode('<a href', $expl[1])[0]);
                                
                                $genAttrs = [
                                    'd_slug' => $d_slug,
                                    'model_id' => $model->id,
                                ];
                                
                                // isset name
                                if (preg_match( '/(.*?)\ (\[([0-9]{4}?)\ \.\.\ ([0-9]{4}?)\])/', $d_slug, $match)) {
                                    $genAttrs['title'] = $match[1];
                                    $genAttrs['year_from'] = $match[3];
                                    $genAttrs['year_to'] = $match[4];
                                } else if (preg_match( '/(([0-9]{4}?)\ \.\.\ ([0-9]{4}?))/', $d_slug, $match)) {
                                    $genAttrs['year_from'] = $match[2];
                                    $genAttrs['year_to'] = $match[3];
                                    $genAttrs['title'] = '';
                                } else {
                                    echo "GENERATION NO MATCH: \n";
                                }
                                
                                $trimAttrs['generation_id'] = self::getGeneration($genAttrs)->id;
                                
                            } else if ($paramName === 'Engine') {        
                                $trimAttrs['engine_id'] = self::getEngine([
                                    'title' => self::clean(strip_tags(explode('<span class="parameter-name">Engine</span>:', $paramContent)[1])),
                                ])->id;

                            } else if ($paramName === 'Market') {    
                                preg_match('/data-content="(.*?)" data-original-title="(.*?)"/', $paramContent, $marketMatch);
                                $trimAttrs['market_id'] = self::getMarket([
                                    'title' => $marketMatch[1],
                                    'abbr' => $marketMatch[2],
                                ])->id;
                                
                            } else if ($paramName === 'Power') {                              
                                $expl = self::clean(explode('<span class="parameter-name">Power</span>:', $paramContent)[1]);
                                $expl = explode('<span class="stick-divider">|</span>', $expl);
                                
                                if (!empty($expl[1])) {
                                    $trimAttrs['power_hp'] = (int) $expl[0];
                                    $trimAttrs['power_kw'] = (int) $expl[1];
                                    $trimAttrs['power_ps'] = (int) $expl[2];
                                }
                                
                            } else if ($paramName === 'Center Bore') {                              
                                $expl = self::clean(explode('<span class="parameter-name">Center Bore</span>:', $paramContent)[1]);
                                preg_match('/<span id="(.*?)">(.*?)mm<\/span>/', $expl, $cbMatch);
                                $trimAttrs['center_bore'] = !empty($cbMatch[2]) ? ((float) $cbMatch[2]) : null;
                            
                            } else if ($paramName === 'Wheel Fasteners') {                              
                                $expl = self::clean(explode('<span class="parameter-name">Wheel Fasteners</span>:', $paramContent)[1]);
                                $trimAttrs['wheel_fasteners'] = self::clean(explode("<a", $expl)[0]);
                            } else if ($paramName === 'Thread Size') {                              
                                $expl = self::clean(explode('<span class="parameter-name"><!--Lug Size-->Thread Size</span>:', $paramContent)[1]);
                                $trimAttrs['thread_size_id'] = self::getThreadSize([
                                    'title' => self::clean(strip_tags(explode("<a", $expl)[0])),
                                ])->id;
                            } else if ($paramName === 'Trim Production') {                              
                                $expl = self::clean(explode('<span class="parameter-name">Trim Production</span>:', $paramContent)[1]);
                                $trimAttrs['trim_production'] = self::clean(explode("<a", $expl)[0]);
                            } else if ($paramName === 'Options') {                              
                                $expl = self::clean(explode('<span class="parameter-name">Options</span>:', $paramContent)[1]);
                                $trimAttrs['options'] = self::clean($expl);
                            } else if ($paramName === 'Torque') {                              
                                $expl = self::clean(explode('<span class="parameter-name">Torque</span>:', $paramContent)[1]);
                                $trimAttrs['torque'] = (int)self::clean(strip_tags($expl));
                            } else {
                                dd("Unknow param: " . $paramName);
                            }
                        }
                         
                        preg_match('/data-vehicle="(.*?)"/', $item->html(), $matchVehicle);
                        $trimAttrs['vehicle_id'] = $matchVehicle[1];
                        
                        //dd($trimAttrs);
                        
                        $trim = self::getTrim($trimAttrs);
                        echo "\t\t\t\t trim: " . $trim->id . "\n";
                        
                        //////////////////////////////////////////////////////////////////////////
                        // WHEEL
                        //////////////////////////////////////////////////////////////////////////
                        foreach ($item->find('tbody[data-vehicle] tr') as $elemWheel) {
                            $elemWheel = pq($elemWheel);
                            $expl = explode('x', self::clean(pq($elemWheel->find('.data-bolt-pattern[data-pcd]'))->text()));
                            if (empty($modelYear->bolt_pattern_id) && !empty($expl[1])) {
                                $modelYear->bolt_pattern_id = self::getBoltPattern([
                                    'stud' => $expl[0],
                                    'pcd' => $expl[1],
                                ])->id;
                                $modelYear->save();
                            }
                            
                            $elemWheel = pq($elemWheel);
                            $dataTire = pq($elemWheel->find('.data-tire'));
                            $dataRim = pq($elemWheel->find('.data-rim'));
                            $dataPressure = pq($elemWheel->find('.data-pressure'));
                            
                            $explRim = explode("\n", pq($dataRim->find('span[data-rim]'))->text());
                            
                            $frontWheel = self::getWheel(
                                $dataTire->attr('data-front'), 
                                pq($dataTire->find('span.rear-tire-data-full span.tire_load_index'))->text(),
                                $explRim[0]
                            );
                            
                            if (!empty($dataTire->attr('data-rear'))) {
                                $rearWheel = self::getWheel(
                                    $dataTire->attr('data-rear'), 
                                    pq($dataTire->find('span.tire_load_index'))->text(),
                                    isset($explRim[1]) ? $explRim[1] : $explRim[0]
                                );
                            }
                            
                            $explPressure = explode('/', self::clean($dataPressure->find('span.unit-metric-data')->text()));
                            
                            $attrTrimWheel = [
                                'trim_id' => $trim->id,
                                'front_id' => $frontWheel->id,
                                'rear_id' => !empty($rearWheel) ? $rearWheel->id : null,
                                'front_pressure' => !empty($explPressure[0]) ? $explPressure[0] : null,
                                'rear_pressure' => isset($explPressure[1]) ? $explPressure[1] : null,
                                'is_stock' => $elemWheel->attr('class') === 'stock' ? 1 : 0,
                                'is_runflat' => count($dataTire->find('.wheel-pair-icons .runflat')),
                                'is_steel_wheels' => count($dataTire->find('.wheel-pair-icons .steel-rims')),
                            ];
                            dump($attrTrimWheel);
                            $trimWheel = self::getTrimWheel($attrTrimWheel);
                        }
                    }
                    
                    //end ModelYear
                }
                
                //end Model
            }
            
            //end Make
        }       
    }

    /*
     * @return Wheel
     */
    public static function getWheel(string $tire, string $loadIndex, string $rim): Wheel 
    {
        //preg_match('/(d.?)([A-Z.?])x([0-9.?])/', '8.5Jx20', $match);
        //dd($match);
        
        $rim = trim($rim);
        if ($rim !== '') {
            $explRim = explode(' ', $rim);
            if (!(count($explRim) === 2 || 
                (!empty($explRim[1]) && preg_match('/(d.?)([A-Z.?])x([0-9.?])/', $explRim[1])) ||
                (!empty($explRim[2]) && preg_match('/ET([0-9.?])/', $explRim[2]))
             )) {
             file_put_contents(public_path() . '/rim.txt', $rim . "\n", FILE_APPEND);
            }
        }
        
        $loadIndex = self::clean($loadIndex);
        preg_match('/([0-9].?)([A-Z].?)/', $loadIndex, $loadIndexMatch);
        
        $parserTire = new ParserTire($tire);
        $parserRim = !empty($rim) ? (new ParserRim($rim)) : null;
        $data = [
            'tire_width' => $parserTire->getWidth(),
            'aspect_ratio' => $parserTire->getAspectRatio(),
            'construction' => $parserTire->getSpeedRating(),
            'rim_diameter' => $parserTire->getRimDiameter(),
            'load_index' => isset($loadIndexMatch[1]) ? $loadIndexMatch[1] : null,
            'speed_rating' => isset($loadIndexMatch[2]) ? $loadIndexMatch[2] : null,
            'rim_width' => $parserRim ? $parserRim->getWidth() : null,
            'offset' => $parserRim ? $parserRim->getOffset() : null,
        ];
        
        $query = Wheel::query();
        
        foreach ($data as $attr => $value) {
            if ($value === null) {
                $query->whereNull($attr);
            } else {
                $query->where($attr, $value);
            }
        }
        
        $model = $query->first();
        
        if ($model === null) {
            $model = Wheel::create($data);
        }
        
        return $model;
    }

    /*
     * @return BoltPattern
     */
    public static function getBoltPattern(array $data): BoltPattern 
    {
        $query = BoltPattern::query();
        
        foreach ($data as $attr => $value) {
            if ($value === null) {
                $query->whereNull($attr);
            } else {
                $query->where($attr, $value);
            }
        }
        
        $model = $query->first();
        
        if ($model === null) {
            $model = BoltPattern::create($data);
        }
        
        return $model;
    }

    /*
     * @return TrimWheel
     */
    public static function getTrimWheel(array $data): TrimWheel 
    {
        $query = TrimWheel::query();
        
        foreach ($data as $attr => $value) {
            if ($value === null) {
                $query->whereNull($attr);
            } else {
                $query->where($attr, $value);
            }
        }
        
        $model = $query->first();
        
        if ($model === null) {
            $model = TrimWheel::create($data);
        }
        
        return $model;
    }

    
    public static function clean($str)
    {
        $str = trim($str);
        return str_replace(["\n", "\t", "\r"], '', $str);
    }
    
    /*
     * @return Make
     */
    public static function getMake(array $data): Make 
    {
        $mapMakeSlug = [
            'faw-besturn' => 'faw',
        ];
        if (isset($mapMakeSlug[$data['slug']])) {
            $data['slug'] = $mapMakeSlug[$data['slug']];
        }
        
        $make = Make::where('slug', $data['slug'])->first();
        if ($make === null) {
            $attrs = ['slug' => $data['slug']];
            foreach (locales() as $locale) {
                $attrs[$locale] = [
                    'is_translated' => 1,
                    'title' => $data['title'],
                ];
            }
            $make = Make::create($attrs);
        }
        
        return $make;
    }

    /*
     * @return Model
     */
    public static function getModel(array $data): Model 
    {
        $model = Model::where('slug', $data['slug'])
            ->where('make_id', $data['make_id'])
            ->first();
        
        if ($model === null) {
            $attrs = [
                'slug' => $data['slug'],
                'make_id' => $data['make_id'],
            ];
            foreach (locales() as $locale) {
                $attrs[$locale] = [
                    'is_translated' => 1,
                    'title' => $data['title'],
                ];
            }
            $model = Model::create($attrs);
        }
        
        return $model;
    }

    /*
     * @return ModelYear
     */
    public static function getModelYear(array $data): ModelYear 
    {
        $modelYear = ModelYear::where('year', $data['year'])
            ->where('model_id', $data['model_id'])
            ->first();
        
        if ($modelYear === null) {
            $modelYear = ModelYear::create($data);
        }
        
        if (!empty($data['img_url']) && empty($modelYear->image)) {
            $imgContent = Curl::getPage($data['img_url'], ['noCache' => true]);
            if (!empty($imgContent)) {
                $imgManager = resolve('App\Services\Image\ImageService');
                $modelYear->image = $imgManager->saveFromContent($imgContent, Str::slug($data['img_title']) . '.png'); 
                $modelYear->save();
            }
        }
        
        return $modelYear;
    }

    /*
     * @return Generation
     */
    public static function getGeneration(array $data): Generation 
    {
        $model = Generation::where('model_id', $data['model_id'])
            ->where('d_slug', $data['d_slug'])
            ->first();
        
        if ($model === null) {
            foreach (locales() as $locale) {
                $data[$locale] = [
                    'is_translated' => 1,
                    'title' => $data['title'],
                ];
            }
            
            if (!empty($data['img_content']) && empty($model->image)) {
                $imgManager = resolve('App\Services\Image\ImageService');
                $data['image'] = $imgManager->saveFromContent($data['img_content'], Str::slug($data['title']) . '.png'); 
            }
                    
            $model = Generation::create($data);
        }
        
        return $model;
    }
        
    /*
     * @return Engine
     */
    public static function getEngine(array $data): Engine 
    {
        $model = Engine::where('title', $data['title'])
            ->first();
        
        if ($model === null) {
            $model = Engine::create($data);
        }
        
        return $model;
    }
    
    /*
     * @return Market
     */
    public static function getMarket(array $data): Market 
    {
        $data['slug'] = Str::slug($data['abbr']);
        
        $model = Market::where('abbr', $data['abbr'])
            ->first();
        
        if ($model === null) {
            foreach (locales() as $locale) {
                $data[$locale] = [
                    'is_translated' => 1,
                    'title' => $data['title'],
                ];
            }
            $model = Market::create($data);
        }
        
        return $model;
    }
    
    /*
     * @return ThreadSize
     */
    public static function getThreadSize(array $data): ThreadSize 
    {
        $model = ThreadSize::where('title', $data['title'])
            ->first();
        
        if ($model === null) {
            $model = ThreadSize::create($data);
        }
        
        return $model;
    }
    
    /*
     * @return Trim
     */
    public static function getTrim(array $data): Trim 
    {
        $query = Trim::where('title', $data['title'])
            ->where('model_year_id', $data['model_year_id']);
        if (empty($data['market_id'])) {
            $query->whereNull('market_id');
        } else {
            $query->where('market_id', $data['market_id']);
        }
        $model = $query->first();
        
        if ($model === null) {
            $model = Trim::create($data);
        } else {
            $model->update($data);
        }
        
        return $model;
    }
    
    
}
