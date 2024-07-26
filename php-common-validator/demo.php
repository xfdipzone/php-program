<?php
require 'CommonValidator.php';

// 测试的方法集合$
$test_funcs = [
    'TestEmpty', 'TestLength', 'TestNumber', 'TestIsEnglish', 'TestHttp', 'TestDomain',
    'TestIsChinese', 'TestIsThai', 'TestIsVietnamese'
];

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
            'val' => 'abc',
            'min_length' => 3,
            'max_length' => 3,
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

// 测试 number
function TestNumber()
{
    $cases = array(
        array(
            'val' => 123,
            'allow_float' => false,
            'allow_signed' => false,
            'want_ret' => true
        ),
        array(
            'val' => 123.45,
            'allow_float' => false,
            'allow_signed' => false,
            'want_ret' => false
        ),
        array(
            'val' => 123.45,
            'allow_float' => true,
            'allow_signed' => false,
            'want_ret' => true
        ),
        array(
            'val' => -123.45,
            'allow_float' => true,
            'allow_signed' => false,
            'want_ret' => false
        ),
        array(
            'val' => -123.45,
            'allow_float' => true,
            'allow_signed' => true,
            'want_ret' => true
        ),
        array(
            'val' => 'abc',
            'allow_float' => false,
            'allow_signed' => false,
            'want_ret' => false
        ),
        array(
            'val' => null,
            'allow_float' => false,
            'allow_signed' => false,
            'want_ret' => false
        ),
    );

    foreach($cases as $case)
    {
        $ret = \CommonValidator::number($case['val'], $case['allow_float'], $case['allow_signed']);
        assert($case['want_ret']==$ret);
    }
}

// 测试 http
function TestHttp()
{
    $cases = array(
        array(
            'val' => 'http://www.fdipzone.com',
            'want_ret' => true
        ),
        array(
            'val' => 'https://www.fdipzone.com',
            'want_ret' => true
        ),
        array(
            'val' => 'ftp://www.fdipzone.com',
            'want_ret' => false
        ),
        array(
            'val' => 'http://fdipzone',
            'want_ret' => false
        ),
        array(
            'val' => 'https://www.fdipzone..com',
            'want_ret' => false
        ),
    );

    foreach($cases as $case)
    {
        $ret = \CommonValidator::http($case['val']);
        assert($case['want_ret']==$ret);
    }
}

// 测试 domain
function TestDomain()
{
    $cases = array(
        array(
            'val' => 'www.fdipzone.com',
            'want_ret' => true
        ),
        array(
            'val' => 'www.fdipzone.net',
            'want_ret' => true
        ),
        array(
            'val' => 'www.fdipzone..com',
            'want_ret' => false
        ),
    );

    foreach($cases as $case)
    {
        $ret = \CommonValidator::domain($case['val']);
        assert($case['want_ret']==$ret);
    }
}

// 测试 isEnglish
function TestIsEnglish()
{
    $cases = array(
        array(
            'val' => 'hello',
            'want_ret' => true
        ),
        array(
            'val' => '你好',
            'want_ret' => false
        ),
        array(
            'val' => 'สวัสดี',
            'want_ret' => false
        ),
        array(
            'val' => 'Xin chào',
            'want_ret' => false
        ),
    );

    foreach($cases as $case)
    {
        $ret = \CommonValidator::isEnglish($case['val']);
        assert($case['want_ret']==$ret);
    }
}

// 测试 isChinese
function TestIsChinese()
{
    $cases = array(
        array(
            'val' => '你好',
            'want_ret' => true
        ),
        array(
            'val' => 'hello',
            'want_ret' => false
        ),
        array(
            'val' => 'สวัสดี',
            'want_ret' => false
        ),
        array(
            'val' => 'Xin chào',
            'want_ret' => false
        ),
    );

    foreach($cases as $case)
    {
        $ret = \CommonValidator::isChinese($case['val']);
        assert($case['want_ret']==$ret);
    }
}

// 测试 isThai
function TestIsThai()
{
    $cases = array(
        array(
            'val' => 'สวัสดี',
            'want_ret' => true
        ),
        array(
            'val' => 'hello',
            'want_ret' => false
        ),
        array(
            'val' => '你好',
            'want_ret' => false
        ),
        array(
            'val' => 'Xin chào',
            'want_ret' => false
        ),
    );

    foreach($cases as $case)
    {
        $ret = \CommonValidator::isThai($case['val']);
        assert($case['want_ret']==$ret);
    }
}

// 测试 isVietnamese
function TestIsVietnamese()
{
    $cases = array(
        array(
            'val' => 'Xin chào',
            'want_ret' => true
        ),
        array(
            'val' => 'hello',
            'want_ret' => true
        ),
        array(
            'val' => '你好',
            'want_ret' => false
        ),
        array(
            'val' => 'สวัสดี',
            'want_ret' => false
        ),
    );

    foreach($cases as $case)
    {
        $ret = \CommonValidator::isVietnamese($case['val']);
        assert($case['want_ret']==$ret);
    }
}