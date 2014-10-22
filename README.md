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

Collections are implemented as dinamic methods. For example `$tp_client->Tasks()` or  `$tp_client->Users()` and etc.

Use [reference](https://md5.tpondemand.com/api/v1/index/meta) to get collection names

Create client

```php
$cl = new \ToEcto\TargetprocessPHPClient\Client('http://domain.com/api/v1/', 'user', 'password');
```


Get list of objects, it is limited you will have to request more with additional parameters if list is long

```php
$array = $cl->Users()->get();
$array = $cl->Users()->get('', array('take' => 25, 'skip' => 25));
```

Will make few requests for at gete full list
Be carefull with long lists!

```php
$array = $cl->Users()->getAll();
```

Get one user

```php
$array = $cl->Users()->get(18);
```

Add object

```php
$cl->Users()->add($array);
```

Update object

```php
$cl->Users()->set($id, $array);
```


Note: `add()` and `set()` return client object itself
Use `getResponse()` in order to get last responce object:

```php
$cl->getResponse();
```


Handle errors for default transport

```php
try {
    $tp_entity = $tp_client->Assignables()->get($entityID);
} catch (\GuzzleHttp\Exception\ClientException $e) {
    if ($e->getResponse()->getStatusCode() == 404) {
        error_log('Entity tp-'.$entityID.' does not exist');
        return;
    }
}
```

## Sub collections

Get All tasks for user with id = 18

```php
$array = $cl->Users()->open(18)->Assignables()->getAll();
```

Dynamic properties shortcut

```php
$array = $cl->Users()->open(18)->Assignables;
```

is equal to

```php
$array = $cl->Users()->open(18)->Assignables()->get();
```
