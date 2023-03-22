<?php
require 'autoload.php';

// AppKey
$app_key = '您申请的AppKey';

// 长链接
$urls = array(
    'https://blog.csdn.net/fdipzone/article/details/46390573',
    'https://blog.csdn.net/fdipzone/article/details/12180523',
    'https://blog.csdn.net/fdipzone/article/details/9316385'
);

// 生成短链接
$config = array(
    'app_key' => $app_key
);
$generator = ShortUrlGenerator\Generator::make(ShortUrlGenerator\Type::SINA, $config);
$result = $generator->generate($urls);

print_r($result);
?>