<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

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
     * @param array $queryParams
     * @return mixed
     */
    public static function getData($api, $jsonToArray, $url = '', array $queryParams = [])
    {
        $client = new Client();
        try {
            $response = $client->request('GET', $api->host.$url, [
                'headers' => [
                    'Authorization' => $api->token
                ],
                'query' => $queryParams
            ]);
            if ($jsonToArray) {
                $resData = $response->getBody()->getContents();
                return (array) json_decode($resData);
            } else {
                return json_decode($response->getBody()->getContents());
            }
        } catch (ClientException $e) {
            if ($jsonToArray)
                return (array) json_decode($e->getResponse()->getBody()->getContents());
            else
                return json_decode($e->getResponse()->getBody()->getContents());
        }
    }

    /**
     * Return always JSON
     *
     * @param $api
     * @param string $url
     * @param array $queryParams
     * @return mixed
     */
    public static function getImage($api, $url = '', array $queryParams = [])
    {
        $client = new Client();
        $response = $client->request('GET', $api->host.$url, [
            'headers' => [
                'Authorization' => $api->token
            ],
            'query' => $queryParams
        ]);
        return $response->getBody()->getContents();
    }
}