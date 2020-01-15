<?php

namespace App\Services;

class Curl
{    
	public static function getPage($url, $params = [])
	{
        $result = null;
        
        $file = storage_path() . '/parser/' . str_replace([':', '/', '.'], "_", $url) . '.html';
        if (is_file($file)) {
            $result = file_get_contents($file);
        } else {
        
            $file = storage_path() . '/parser/' . md5($url) . '.html';

            if (!is_file($file)) {
                sleep(1);

                if (!empty($params['post']) && is_array($params['post'])) {
                    $params['post'] = http_build_query($params['post']);    
                }

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

                // откуда пришли на эту страницу
                if (empty($params['ref'])) {
                    $params['ref'] = $url;
                }

                curl_setopt($ch, CURLOPT_REFERER, $params['ref']);

                // не проверять SSL сертификат
                curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
                // не проверять Host SSL сертификата
                curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
                // это необходимо, чтобы cURL не высылал заголовок на ожидание
                curl_setopt ($ch, CURLOPT_HTTPHEADER, array('Expect:'));
                curl_setopt($ch, CURLOPT_HEADER, 0);
                
                sleep(2);
                $result = curl_exec($ch);
                $error = curl_error($ch);

                $result = trim($result);
                if (empty($result) || substr_count($result, 'Internal Server Error')) {
                    //file_put_contents(public_path() . 'i.txt', $url . "\n", FILE_APPEND);
                    //return null;
                    echo $url . "\n";
                    sleep(30);
                    return self::getPage($url, $params);
                }
                
                if (empty($params['noCache'])) {
                    file_put_contents($file, $result);
                }
 
            } else {
                $result = file_get_contents($file);
            }
        }
        
        if (substr_count($result, 'Internal Server Error')) {
            unlink($file);
            return self::getPage($url, $params);
        }
        
		return $result;
	}		
}