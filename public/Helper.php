<?php

use GuzzleHttp\Client;

class Helper
{
    /**
     * Возращает настройки в JSON'e
     *
     * @param $data
     * @return mixed
     */
    public static function getJSON($data)
    {
        return json_decode(json_encode($data));
    }

    /**
     * Return always JSON
     *
     * @param $api
     * @param $jsonToArray
     * @param string $url
     * @return mixed
     */
    public static function getData($api, $jsonToArray, $url = '')
    {
        $client = new Client();
        $response = $client->request('GET', $api->host.'/catalogs'.$url, [
            'headers' => [
                'Authorization' => $api->token
            ]
        ]);

        if ($jsonToArray)
            return (array) json_decode($response->getBody()->getContents());
        else
            return json_decode($response->getBody()->getContents());
    }

    /**
     * Return always JSON
     *
     * @param $api
     * @param string $url
     * @return mixed
     */
    public static function getImage($api, $url = '')
    {
        $client = new Client();
        $response = $client->request('GET', $api->host.'/catalogs'.$url, [
            'headers' => [
                'Authorization' => $api->token
            ]
        ]);
        return $response->getBody()->getContents();
    }
}