<?php
Require 'RedisBucket.class.php';

// redis连接设定
$config = array(
    'host' => 'localhost',
    'port' => 6379,
    'index' => 0,
    'auth' => '',
    'timeout' => 1,
    'reserved' => NULL,
    'retry_interval' => 100,
);

// 定义bucket名称
$bucket = 'mybucket';

// 创建bucket对象
$oRedisBucket = new RedisBucket($config, $bucket);

// 初始化
$oRedisBucket->init();

// 设置最大容量
$oRedisBucket->set_max_size(3);

// 设置锁超时时间
$oRedisBucket->set_lock_timeout(300);

// 设置执行超时时间
$oRedisBucket->set_timeout(2000);

// 设置重试间隔时间
$oRedisBucket->set_retry_time(10);

// 压入3条数据
$result = $oRedisBucket->push('a');
print_r($result);

$result = $oRedisBucket->push('b');
print_r($result);

$result = $oRedisBucket->push('c');
print_r($result);

// 查看已使用容量及最大容量
var_dump(assert($oRedisBucket->get_used_size()==3));
var_dump(assert($oRedisBucket->get_max_size()==3));

// 压入1条数据，不强制弹出，容器已满
$result = $oRedisBucket->push('d');
print_r($result);

// 压入1条数据，强制弹出
$result = $oRedisBucket->push('d', 1);
print_r($result);

// 设置最大容量为5，比已用容量大，不用弹出数据
$result = $oRedisBucket->set_max_size(5);
print_r($result);

// 压入2条数据
$oRedisBucket->push('e');
$oRedisBucket->push('f');

// 查看已使用容量及最大容量
var_dump(assert($oRedisBucket->get_used_size()==5));
var_dump(assert($oRedisBucket->get_max_size()==5));

// 弹出3条数据
$result = $oRedisBucket->pop(3);
print_r($result);

// 查看已使用容量及最大容量
var_dump(assert($oRedisBucket->get_used_size()==2));
var_dump(assert($oRedisBucket->get_max_size()==5));

// 设置最大容量为1，比已用容量小，弹出数据
$result = $oRedisBucket->set_max_size(1);
print_r($result);

// 查看已使用容量及最大容量
var_dump(assert($oRedisBucket->get_used_size()==1));
var_dump(assert($oRedisBucket->get_max_size()==1));

?>