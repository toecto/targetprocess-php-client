<?php

namespace ToEcto\TargetprocessPHPClient;

class Transport {
    protected $http_client;

    public function __construct($tp_api_link, $user, $pass) {
        $this->http_client = new \GuzzleHttp\Client(array(
            'base_url' => $tp_api_link,
            'defaults'=> array(
                'headers' => array(
                    'Accept' => 'application/json',
                ),
                'config' => array(
                    'curl' => array(
                        CURLOPT_HTTPAUTH => CURLAUTH_NTLM,
                        CURLOPT_USERPWD  => $user . ':' . $pass
                    )
                )
            )
        ));
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
        return $this->http_client->$method($target, $data)->json();
    }

}
