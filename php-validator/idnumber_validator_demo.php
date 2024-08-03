<?php
require 'autoload.php';

// 测试的方法集合
$test_funcs = [
    'TestIDCard',
];

foreach($test_funcs as $func)
{
    echo '测试 '.$func.PHP_EOL;
    $func();
}

// 测试 IDCard
function TestIDCard()
{
    $cases = array(
        array(
            'val' => '441234567890123456',
            'want_ret' => false,
        ),
        array(
            'val' => '44123456789012',
            'want_ret' => false,
        ),
        array(
            'val' => 'abcd1234abcd1234cd',
            'want_ret' => false,
        ),
        array(
            'val' => '440101199901010009',
            'want_ret' => true,
        ),
    );

    foreach($cases as $case)
    {
        $ret = \Validator\IDNumberValidator::idCard($case['val']);
        assert($case['want_ret']==$ret);
    }
}