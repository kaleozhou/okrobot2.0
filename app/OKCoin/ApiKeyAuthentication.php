<?php
namespace App\OKCoin;

class ApiKeyAuthentication extends Authentication
{
    public $_apiKey;
    public $_apiKeySecret;

    public function __construct($apiKey, $apiKeySecret)
    {
        $this->_apiKey = $apiKey;
        $this->_apiKeySecret = $apiKeySecret;
    }

    public function getData()
    {

        $app=app();
        $data = $app->make('stdClass');
        $data->apiKey = $this->_apiKey;
        $data->apiKeySecret = $this->_apiKeySecret;
        return $data;
    }
}
