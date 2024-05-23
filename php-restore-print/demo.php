<?php
require 'RestorePrint.php';

$print_r_data = <<<TXT
Array
(
    [name] => fdipzone
    [gender] => male
    [age] => 18
    [profession] => programmer
    [detail] => Array
        (
            [grade] => 1
            [create_time] => 2024-05-23
        )
)
TXT;

// 显示打印的数据
echo '显示打印的数据：'.PHP_EOL;
echo $print_r_data.PHP_EOL;

$oRestorePrint = new RestorePrint;
$oRestorePrint->set('Array', 'group');
$oRestorePrint->set(' [', 'brackets,[');
$oRestorePrint->set('] => ', 'brackets,]');
$oRestorePrint->set(')', 'brackets,)');

$result = $oRestorePrint->parse($print_r_data);

echo PHP_EOL.'还原为数组：'.PHP_EOL;
var_dump($result);