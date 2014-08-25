<?php

namespace ToEcto\TargetprocessPHPClient\Modules;

class BaseCollection {
    protected $url;
    protected $base_client;
    protected $connection;
    protected $response;

    public function __construct($base_client, $url) {
        $this->base_client = $base_client;
        $this->connection = $base_client->getConnection();
        $this->url = $url;
        $this->init();
    }

    protected function init() {
    }

    public function getConnection() {
        return $this->connection;
    }

    public function getResponse() {
        return $this->response;
    }

    public function get($id, $args = null) {
        return $this->connection->get($this->url . $id . '/', $args);
    }

    public function getAll($args = null) {
        $data = array();
        $link = $this->url;
        do {
            $rez = $this->connection->get($link, $args);
            $data = array_merge($data, $rez['Items']);
            if (isset($rez['Next'])) {
                $link = $rez['Next'];
            }
        } while (isset($rez['Next']));
        return $data;
    }

    public function set($id, $data = null) {
        $this->response = $this->connection->post($this->url . $id . '/', $data);
        return $this;
    }

    public function add($data) {
        $this->response = $this->connection->post($this->url, $data);
        return $this;
    }

    public function open($name, $args = null) {
        $module_class = 'ToEcto\\TargetprocessPHPClient\\Modules\\'.$name;
        if (!class_exists($module_class)) {
            $module_class = 'ToEcto\\TargetprocessPHPClient\\Modules\\BaseCollection';
        }

        return new $module_class($this->base_client, $this->url . $name . '/');
    }

    public function __call($name, $args) {
        return $this->open($name, $args);
    }

    public function __get($name) {
        return $this->get($name);
    }

}
