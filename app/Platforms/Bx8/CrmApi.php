<?php
namespace App\Platforms\Bx8;

use GuzzleHttp\Client;

class CrmApi
{
    private $url;

    private $username;

    private $password;

    private $client;

    public function __construct()
    {
        $this->url = config('bx8.crmUrl');
        $this->username = config('bx8.crmUser');
        $this->password = config('bx8.crmPassword');
        $this->client = new Client([
            'timeout' => 10,
            'base_uri' => $this->url,
            'verify'    => false,
        ]);
    }

    public function makeRequest($action, $requestData)
    {
        $requestData = array_merge($requestData, [
            'apiUsername' => $this->username,
            'apiPassword' => $this->password
        ]);
        try {
            $res = $this->client->post($action, [
                'form_params' => $requestData
            ]);
        } catch(\Exception $exception) {
            if(is_null($exception->getResponse())){
                return [];
            }
            return json_decode($exception->getResponse()->getBody()->getContents(), true);
        }
        return json_decode($res->getBody()->getContents(), true);
    }
}