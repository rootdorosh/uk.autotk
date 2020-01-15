<?php

namespace App\Modules\Translation\Services\Fetch;

use Illuminate\Support\Collection;
use App\Modules\Translation\Models\Translation;
use App\Base\FetchService;
use Cache;

/**
 * Class TranslationFetchService
 */
class TranslationFetchService extends FetchService
{    
    /**
     * @return array
     */
    public function getData(): array
    {
        $key = $this->tag . '_getData_' . l();
        
        return Cache::tags($this->tag)->remember($key, 60*60*24, function() {
            return $this->model::get()->pluck('value', 'slug')->toArray();
        });        
    } 

    /**
     * @param strin $slug
     * @param array $params
     * @return string
     */
    public function get(string $slug, array $params = []): string
    {
        $data = $this->getData();
        
        $text =  isset($data[$slug]) ? $data[$slug] : $slug;
        
        if (!empty($params)) {
            preg_match_all('/(\[(.*?)\])/', $text, $matches);
            foreach ($matches[2] as $index => $var) {
                if (isset($params[$index])) {
                    $text = str_replace("[{$var}]", $params[$index], $text);
                }
            }
        }
        
        return $text;
    } 
}
