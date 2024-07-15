<?php
require 'TimeZoneConversion.php';

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
