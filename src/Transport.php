<?php

namespace ToEcto\TargetprocessPHPClient;

class Transport {

    protected $http_client;

    public function __construct($tp_api_link, $user, $pass, $guzzle_config = array()) {
        $default_guzzle_config = array(
            'base_uri' => $tp_api_link,
            'auth' => [$user, $pass],
            'headers' => array(
                'Accept' => 'application/json',
            ),
        );

        $merged_guzzle_config = array_merge($default_guzzle_config, $guzzle_config);

        $this->http_client = new \GuzzleHttp\Client($merged_guzzle_config);
    }

    public function get($collection, $query = null) {
        return $this->send('get', $collection, null, $query);
    }

    public function post($collection, $body, $query = null) {
        return $this->send('post', $collection, $body, $query);
    }

    protected function send($method, $collection, $body = null, $query = null) {
        $data = array();
        if ($query) {
            $data['query'] = $query;
        }
        if ($body) {
            $data['json'] = $body;
        }
        $target = $collection;

        /** @var \GuzzleHttp\Psr7\Response $response */
        $response = $this->http_client->$method($target, $data);

        return json_decode($response->getBody(), true);
    }

}
