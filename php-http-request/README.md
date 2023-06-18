# php-http-request

php Http Request

## 介绍

php HttpRequest请求类，基于 `fsockopen()` 实现，支持 `GET`, `POST`, `Multipart/form-data` 方式请求。

**fsockopen** 使用说明 [https://www.php.net/manual/en/function.fsockopen.php](https://www.php.net/manual/en/function.fsockopen.php)

---

## 功能

支持 GET, POST(application/x-www-form-urlencoded), POST(multipart/form-data) 请求方式

支持 http transfer decode (chunked)

支持两种请求数据

- form data（提交表单数据）

- file data（上传文件）

---

## 演示

```php
require 'autoload.php';

// connect config
$host = 'localhost';
$port = 80;
$connect_config = new \HttpRequest\Connect\Config($host, $port);

// create http request
$http_request_handler = new \HttpRequest\Actuator($connect_config);

// request data
$request_form_data = array(
    'name' => 'fdipzone',
    'profession' => 'programmer',
);
$form_data = new \HttpRequest\RequestData\FormData($request_form_data);

$photo = dirname(__FILE__).'/pic/photo.jpg';
$file_data = new \HttpRequest\RequestData\FileData('photo', $photo);

// request set
$request_set = new \HttpRequest\RequestSet;
$request_set->add($form_data);
$request_set->add($file_data);

// send
$url = '/server.php';

try
{
    // GET
    $response = $http_request_handler->send($url, $request_set, \HttpRequest\RequestMethod::GET);
    echo 'GET Request Result:';
    echo $response->data().PHP_EOL;

    // POST
    $response = $http_request_handler->send($url, $request_set, \HttpRequest\RequestMethod::POST);
    echo 'POST Request Result:';
    echo $response->data().PHP_EOL;

    // MultiPart
    $response = $http_request_handler->send($url, $request_set, \HttpRequest\RequestMethod::MULTIPART);
    echo 'MultiPart Request Result:';
    echo $response->data().PHP_EOL;
}
catch(\Throwable $e)
{
    echo $e->getMessage();
}
```
