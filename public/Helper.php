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
     * @param $url
     * @return mixed
     */
    public static function getData($api, $url)
    {
        $client = new Client();
        $response = $client->request('GET', $api->host.$url, [
            'headers' => [
                'Authorization' => $api->token
            ]
        ]);

        return json_decode($response->getBody()->getContents());
    }
}