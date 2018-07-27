<?php
namespace App\Platforms\Bx8;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class Api
{
    /**
     * Guzzle main client
     * @var Client
     */
    protected $client;

    function __construct($trading = false)
    {
        $this->client = new Client([
            'timeout' => 10,
            'base_uri' => $trading ? config('bx8.tradingUrl') : config('bx8.baseUrl'),
        ]);
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return setting('api.token');
    }

    /**
     * @param $action
     * @param array $params
     * @param string $method ("get"|"post")
     * @return array
     */
    public function sendRequest($action, $params = [], $method = 'get')
    {
        try {
            switch ($method) {
                case 'post':
                    $res = $this->client->post($action, [
                        'headers' => ['Authorization' => ['Basic ' . $this->getToken()]],
                        'json' => $params,
                    ]);
                    break;
                case 'file':
                    $res = $this->client->post($action, [
                        'headers' => [
                            'Authorization' => ['Basic ' . $this->getToken()],
//                            'Content-type' => 'multipart/form-data',
                        ],
                        'multipart' => $params,
                    ]);
                    break;
                case 'get':
                default:
                    $res = $this->client->get($action, [
                        'headers' => ['Authorization' => ['Basic ' . $this->getToken()]],
                        'query' => $params,
                    ]);
                    break;
            }
            $content = json_decode($res->getBody()->getContents(), true);
            return $content;
        } catch (RequestException $exception) {
            if (is_null($exception->getResponse())) {
                return [];
            }
            \Log::error("Bx8 platform error: " . $exception->getMessage());
            return json_decode($exception->getResponse()->getBody()->getContents(), true);
        }
    }
}