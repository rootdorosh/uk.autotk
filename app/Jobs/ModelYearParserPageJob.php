<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\Xml\Service as FeedService;
use HeadlessChromium\BrowserFactory;
use App\Services\Curl;
use Exception;

class ModelYearParserPageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /*
     * @var string
     */
    protected $params;

    /**
     * Create a new job instance.
     *
     * @param array $params
     * @return void
     */
    public function __construct(array $params)
    {
        $this->params = $params;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $fileOk = public_path() . "/parser-ok/" . $this->params['model_year_id'] . ".html";
        if (!is_file($fileOk)) {
        
			$yearContent = Curl::getPage($this->params['url']);
			preg_match( "/sRwd\=\'\/data\/js\/(.*?)\/'/", $yearContent, $matchCode);
			unset($yearContent);
			if (!isset($matchCode[1])) {
				return;
			}
			
			
			$code = Curl::getPage('https://www.wheel-size.com/data/js/' . $matchCode[1] . '/');
			unset($matchCode);
			
			$htmlPage= \phpQuery::newDocument(Curl::getPage($this->params['url']));
			$body = $htmlPage->find('#vehicle-market-data')->html();
			unset($htmlPage);
			
			$file = "/parser/". $this->params['model_year_id'] .".html";
			file_put_contents(public_path() . $file, (string)view('parser.year', compact('code', 'body')));
			unset($code, $body);

			$page = ((new BrowserFactory())->createBrowser())->createPage();
			$page->navigate('http://uk.autotk.loc' . $file)->waitForNavigation(\HeadlessChromium\Page::LOAD);
		
			$content = str_replace(['â€“', 'Â'], '', (\phpQuery::newDocument('<html>' . 
				self::clean(($page->evaluate('document.documentElement.innerHTML'))->getReturnValue()) .
				'</html>'))->html()
			);
			unset($page);
			file_put_contents($fileOk, $content);
			unset($content);
        }
    }
  
    public static function clean($str)
    {
        $str = trim($str);
        return str_replace(["\n", "\t", "\r"], '', $str);
    }
		
	public function failed(Exception $exception) 
	{
		info($exception);
	}		
}
