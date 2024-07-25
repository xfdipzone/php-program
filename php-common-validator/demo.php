<?php
require 'CommonValidator.php';

// 测试的方法集合$
$test_funcs = ['TestEmpty', 'TestLength'];

foreach($test_funcs as $func)
{
    echo '测试 '.$func.PHP_EOL;
    $func();
}

// 测试 empty
function TestEmpty()
{
    $cases = array(
        array(
            'val' => '',
            'ignore_zero' => true,
            'want_ret' => true
        ),
        array(
            'val' => 'abc',
            'ignore_zero' => true,
            'want_ret' => false
        ),
        array(
            'val' => '0',
            'ignore_zero' => true,
            'want_ret' => true
        ),
        array(
            'val' => '0',
            'ignore_zero' => false,
            'want_ret' => false
        ),
        array(
            'val' => '',
            'ignore_zero' => true,
            'want_ret' => true
        ),
    );

    foreach($cases as $case)
    {
        $ret = \CommonValidator::empty($case['val'], $case['ignore_zero']);
        assert($case['want_ret']==$ret);
    }
}

// 测试 length
function TestLength()
{
    $cases = array(
        array(
            'val' => 'abc',
            'min_length' => 1,
            'max_length' => 5,
            'want_ret' => true
        ),
        array(
            'val' => 'a',
            'min_length' => 2,
            'max_length' => 5,
            'want_ret' => false
        ),
        array(
            'val' => 'abc',
            'min_length' => 6,
            'max_length' => 5,
            'want_ret' => false,
            'want_exception' => 'common validator: min length > max length invalid'
        ),
    );

    foreach($cases as $case)
    {
        try
        {
            $ret = \CommonValidator::length($case['val'], $case['min_length'], $case['max_length']);
            assert($case['want_ret']==$ret);
        }
        catch(\Throwable $e)
        {
            assert($case['want_exception']==$e->getMessage());
        }
    }
}