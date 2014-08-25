<?php

namespace ToEcto\TargetprocessPHPClient;

class Client extends Modules\BaseCollection {

    public function __construct($tp_api_link, $user = null, $pass = null) {
        if (is_object($tp_api_link)) {
            $this->connection = $tp_api_link;
        } else {
            $this->connection = new Transport($tp_api_link, $user, $pass);
        }
        parent::__construct($this, '');
    }


}
