<?php
require 'TimeZoneConversion.php';

TestConvert();
TestTimestampConvert();

// 测试日期时间时区转换
function TestConvert()
{
    $cases = array(
        array(
            'ori_datetime' => '2024-07-15 21:00:00',
            'ori_timezone' => 'GMT+0800',
            'dest_timezone' => 'GMT+0700',
            'dest_format' => 'Y-m-d H:i:s',
        ),
        array(
            'ori_datetime' => '2024-07-15 22:00:00',
            'ori_timezone' => 'GMT+0000',
            'dest_timezone' => 'GMT+0800',
            'dest_format' => 'Y-m-d H:i:s',
        ),
    );

    foreach($cases as $case)
    {
        $resp = TimeZoneConversion::convert($case['ori_datetime'], $case['ori_timezone'], $case['dest_timezone'], $case['dest_format']);
        print_r($resp);
    }
}

// 测试时间戳时区转换
function TestTimestampConvert()
{
    $cases = array(
        array(
            'timestamp' => 1721120701,
            'timezone' => 'GMT+0700',
            'format' => 'Y/m/d/ H:i:s \G\M\TO',
        ),
        array(
            'timestamp' => 1721120701,
            'timezone' => 'GMT+0630',
            'format' => 'Y/m/d/ H:i:s \G\M\TO',
        ),
    );

    foreach($cases as $case)
    {
        $resp = TimeZoneConversion::timestampConvert($case['timestamp'], $case['timezone'], $case['format']);
        echo $resp.PHP_EOL;
    }
}