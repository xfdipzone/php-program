<?php
require 'autoload.php';

// 测试的方法集合
$test_funcs = [
    'TestIsEnglish', 'TestIsChinese', 'TestIsThai', 'TestIsVietnamese'
];

foreach($test_funcs as $func)
{
    echo '测试 '.$func.PHP_EOL;
    $func();
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
        $ret = \Validator\LanguageValidator::isEnglish($case['val']);
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
        $ret = \Validator\LanguageValidator::isChinese($case['val']);
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
        $ret = \Validator\LanguageValidator::isThai($case['val']);
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
        $ret = \Validator\LanguageValidator::isVietnamese($case['val']);
        assert($case['want_ret']==$ret);
    }
}