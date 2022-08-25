<?php

namespace App\Services;

use GuzzleHttp\Client;

class MatomoService {

    protected $url;

    protected $token;

    protected $format = 'JSON';

    protected $module = 'API';

    protected $parameters = [];

    function __construct()
    {
        $this->url = $_ENV['MATOMO_API_URL'];

        $this->token = $_ENV['MATOMO_API_TOKEN'];

        $this->parameters = [
            'token_auth' => $this->token,
            'module' => $this->module,
            'format' => $this->format,
        ];
    }

    protected function query($method, $data = [])
    {
        return [ 'query' => http_build_query(
            array_merge(
                $this->parameters,
                [ 'method' => $method ],
                $data
            )
        )];
    }

    public function call($method, $data = [])
    {
        $http = new Client();
        
        $response = $http->request('GET', $this->url, $this->query($method, $data));

        return json_decode($response->getBody()->getContents());
    }

}