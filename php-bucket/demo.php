<?php
require 'autoload.php';

// redis连接设定
$config = array(
    'host' => 'redis',
    'port' => 6379,
    'index' => 0,
    'auth' => '',
    'timeout' => 1,
    'reserved' => NULL,
    'retry_interval' => 100,
);

// 定义bucket名称
$bucket = 'my-bucket';

// 创建bucket配置对象
$redisBucketConfig = new \Bucket\RedisBucketConfig;
$redisBucketConfig->setConfig($config);
$redisBucketConfig->setName($bucket);

// 创建bucket组件对象
$redisBucket = \Bucket\BucketFactory::make(\Bucket\Type::REDIS, $redisBucketConfig);

// 初始化
$redisBucket->init();

// 设置最大容量
$redisBucket->setMaxSize(3);

// 设置锁超时时间
$redisBucket->setLockTimeout(300);

// 设置执行超时时间
$redisBucket->setTimeout(2000);

// 设置重试间隔时间
$redisBucket->setRetryTime(10);

// 压入3条数据
$response = $redisBucket->push('a');
print_r($response);

$response = $redisBucket->push('b');
print_r($response);

$response = $redisBucket->push('c');
print_r($response);

// 查看已使用容量及最大容量
var_dump(assert($redisBucket->usedSize()==3));
var_dump(assert($redisBucket->maxSize()==3));

// 压入1条数据，不强制弹出，容器已满
$response = $redisBucket->push('d');
print_r($response);

// 压入1条数据，强制弹出
$response = $redisBucket->push('d', 1);
print_r($response);

// 设置最大容量为5，比已用容量大，不用弹出数据
$response = $redisBucket->setMaxSize(5);
print_r($response);

// 压入2条数据
$redisBucket->push('e');
$redisBucket->push('f');

// 查看已使用容量及最大容量
var_dump(assert($redisBucket->usedSize()==5));
var_dump(assert($redisBucket->maxSize()==5));

// 弹出3条数据
$response = $redisBucket->pop(3);
print_r($response);

// 查看已使用容量及最大容量
var_dump(assert($redisBucket->usedSize()==2));
var_dump(assert($redisBucket->maxSize()==5));

// 设置最大容量为1，比已用容量小，弹出数据
$response = $redisBucket->setMaxSize(1);
print_r($response);

// 查看已使用容量及最大容量
var_dump(assert($redisBucket->usedSize()==1));
var_dump(assert($redisBucket->maxSize()==1));
?>