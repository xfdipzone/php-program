<?php
/**
 * 模拟用户访问消耗令牌，每段时间间隔消耗若干令牌
 */
require 'TrafficShaper.php';

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
$queue = 'my-container';

// 最大令牌数
$max = 10;

// 每次时间间隔随机消耗的令牌数量范围
$consume_token_range = array(2, 8);

// 时间间隔
$time_step = 1;

// 创建TrafficShaper对象
$oTrafficShaper = new TrafficShaper($config, $queue, $max);

// 重设令牌桶，填满令牌
$oTrafficShaper->reset();

// 执行令牌消耗
while(true){
    $consume_num = mt_rand($consume_token_range[0], $consume_token_range[1]);
    for($i=0; $i<$consume_num; $i++){
        $status = $oTrafficShaper->get();
        echo '['.date('Y-m-d H:i:s').'] consume token:'.($status? 'true' : 'false').PHP_EOL;
    }
    sleep($time_step);
}
?>