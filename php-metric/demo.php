<?php
require 'autoload.php';

// 测试 Counter Metric
echo '测试 Counter Metric: 最多执行 3 次'.PHP_EOL;

$counter_metric = new \Metric\Counter(3);
$counter_metric->setCallback(function()
{
    echo 'counter metric callback'.PHP_EOL;
});

while(true)
{
    echo 'do sth'.PHP_EOL;

    if(!$counter_metric->next())
    {
        break;
    }
}

// 测试 Timer Metric
echo PHP_EOL.'测试 Timer Metric: 最多执行 5 秒'.PHP_EOL;

$timer_metric = new \Metric\Timer(5);
$timer_metric->setCallback(function()
{
    echo 'timer metric callback'.PHP_EOL;
});

while(true)
{
    echo 'do sth'.PHP_EOL;
    usleep(300*1000);

    if(!$timer_metric->next())
    {
        break;
    }
}