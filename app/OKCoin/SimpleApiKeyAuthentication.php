<?php
namespace App\OKCoin;
use App\OKCoin\Authentication;
class SimpleApiKeyAuthentication extends Authentication {
	private $_apiKey;

	public function __construct($apiKey) {
		$this -> _apiKey = $apiKey;
	}

	public function getData() {
        $app=app();
		$data = $app->make('stdClass');
		$data -> apiKey = $this -> _apiKey;
		return $data;
	}

}
