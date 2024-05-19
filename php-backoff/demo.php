<?php
require 'autoload.php';

// 配置参数
$start_retry_interval = 5;
$factor = 2;
$max_retry_interval = 300;
$max_retry_times = 8;

// 指数退避算法
$exponential_backoff = new \Backoff\ExponentialBackoff($start_retry_interval, $max_retry_interval, $factor, $max_retry_times);

for($i=0; $i<9; $i++)
{
    $request = new \Backoff\Request($i);
    $response = $exponential_backoff->next($request);
    printf("retry_times=%d, retry=%b, retry_interval=%d\n", $i, $response->retry(), $response->retryInterval());
}