<?php

namespace ToEcto\TargetprocessPHPClient;

class Client {

    protected $http_client;
    protected $modules = array();

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
                        CURLOPT_USERPWD  => $user.':'.$pass
                    )
                )
            )
        ));
    }

    public function getModule($name) {
        if (!$this->modules[$name]) {
            $module_class = 'ToEcto\\TargetprocessPHPClient\\'.$name;
            if (!class_exists($module_class)) {
                throw new Exception("Unknown collection is requested", 1);
            }
            $this->modules[$name] = new $module_class($this->http_client);
        } 
        return $this->modules[$name];
    }

    public function __get($name) {
        return $this->getModule($name);
    }

    public function get($collection, $id = null, $query = null) {
        if (!$query) {
            $query = array();
        }
        $target = $collection;
        if ($id) {
            $target .= '/'.$id;
        }
        $response = $this->http_client->get($target, array('query' => $query));
        return $response->json();
    }

    public function post($collection, $body, $query = null) {
        if (!$query) {
            $query = array();
        }
        $response = $this->http_client->post($collection, array('query' => $query, 'json' => $body));
        return $response->json();
    }

}

