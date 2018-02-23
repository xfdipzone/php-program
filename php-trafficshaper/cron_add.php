<?php
/**
 * 定时任务加入令牌
 */
require 'TrafficShaper.class.php';

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

// 令牌桶容器
$queue = 'mycontainer';

// 最大令牌数
$max = 10;

// 每次时间间隔加入的令牌数
$token_num = 3;

// 时间间隔，最好是能被60整除的数，保证覆盖每一分钟内所有的时间
$time_step = 1;

// 执行次数
$exec_num = (int)(60/$time_step);

// 创建TrafficShaper对象
$oTrafficShaper = new TrafficShaper($config, $queue, $max);

for($i=0; $i<$exec_num; $i++){
    $add_num = $oTrafficShaper->add($token_num);
    echo '['.date('Y-m-d H:i:s').'] add token num:'.$add_num.PHP_EOL;
    sleep($time_step);
}

?>