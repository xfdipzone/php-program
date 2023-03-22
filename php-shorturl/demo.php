<?php
require 'autoload.php';

// AppKey
$api_key = '您申请的AppKey';

// 链接转换
$urls = array(
    'https://blog.csdn.net/fdipzone/article/details/46390573',
    'https://blog.csdn.net/fdipzone/article/details/12180523',
    'https://blog.csdn.net/fdipzone/article/details/9316385'
);

$config = array(
    'api_key' => $api_key
);
$generator = ShortUrlGenerator\Generator::make(ShortUrlGenerator\Type::SINA, $config);
$result = $generator->generate($urls);

print_r($result);
?>