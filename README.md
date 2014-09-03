target-process-php-client
=========================

PHP client for Target Process Management Software

## Instalation using composer:

```
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/toecto/targetprocess-php-client"
        }
    ],

    "require": {
        "toecto/targetprocess-php-client": "dev-master",
    },

```

## Using

Collections are implemented as dinamic methods. For example `$tp_client->Assignables()` or  `$tp_client->Assignables()`

Use [reference](https://md5.tpondemand.com/api/v1/index/meta) to get collection names


```
$tp = new \ToEcto\TargetprocessPHPClient\Client('http://domain.com/api/v1/', 'user', 'password');

$tp_client->Assignables()->get($id); // Get one object
$tp_client->Assignables()->get($id, $args); // $args - is  array of additional GET aruments

$tp_client->Assignables()->getAll(); // Get all, will make multiple http requests
$tp_client->Assignables()->get(''); // usefull if you want handle list manualy


$tp_client->Assignables()->add($arr); // $arr - is the object to add in to the collection
$tp_client->Assignables()->set($id, $arr); // update object

// NOTE: add() and set() return client object itself

// Use getResponce in order to get last responce object
$tp_client->getResponse(); 

```