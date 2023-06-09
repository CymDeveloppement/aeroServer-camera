<?php
namespace App;
use Curl\Curl;

/**
 * 
 */
class apiServer
{

    protected static $base = '/api/';

    public static function sendPicture($picture)
    {

        return self::post([
            'picture' => $picture->curl_file,
            'date' => date('Y-m-d H:i:s', $picture->date),
            'place' => parameters::get('place', 'generic')

        ], 'pictures');

    }

    public static function post($array, $url)
    {
        $curl = self::getCurlObject();
        $curl->post(parameters::get('api server url', null).self::$base.$url, $array);
        return self::curlState($curl);
    }

    public static function getCurlObject()
    {
        $curl = new Curl();
        $curl->setHeader('Accept', 'application/json');
        return $curl;
    }

    public static function curlState($curl)
    {
        if ($curl->error) {
            echo 'Error apiServer: ' . $curl->errorMessage . "\n";
            if (isset($curl->response) && isset($curl->response->message)) {
                echo $curl->response->message. "\n";
            }
            return false;
        } else {
            return true;
        }
    }
}