<?php
require 'autoload.php';

// 测试的方法集合
$test_funcs = [
    'TestEmpty', 'TestLength', 'TestNumber', 'TestHttpUrl', 'TestDomain', 'TestEmail',
    'TestDate', 'TestDatetime', 'TestVersion', 'TestLongitude', 'TestLatitude',
    'TestFileExtension',
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
        $ret = \Validator\CommonValidator::empty($case['val'], $case['ignore_zero']);
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
            'val' => 'abcdef',
            'min_length' => 1,
            'max_length' => 4,
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
            $ret = \Validator\CommonValidator::length($case['val'], $case['min_length'], $case['max_length']);
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
        $ret = \Validator\CommonValidator::number($case['val'], $case['allow_float'], $case['allow_signed']);
        assert($case['want_ret']==$ret);
    }
}

// 测试 httpUrl
function TestHttpUrl()
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
        $ret = \Validator\CommonValidator::httpUrl($case['val']);
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
        $ret = \Validator\CommonValidator::domain($case['val']);
        assert($case['want_ret']==$ret);
    }
}

// 测试 email
function TestEmail()
{
    $cases = array(
        array(
            'val' => 'good@fdipzone.com',
            'want_ret' => true
        ),
        array(
            'val' => 'good@good',
            'want_ret' => false
        ),
    );

    foreach($cases as $case)
    {
        $ret = \Validator\CommonValidator::email($case['val']);
        assert($case['want_ret']==$ret);
    }
}

// 测试 date
function TestDate()
{
    $cases = array(
        array(
            'val' => '1995-01-01',
            'min_year' => 1980,
            'max_year' => 2000,
            'want_ret' => true
        ),
        array(
            'val' => '1988-01-01',
            'min_year' => 1990,
            'max_year' => 2000,
            'want_ret' => false
        ),
        array(
            'val' => '2001-01-01',
            'min_year' => 1990,
            'max_year' => 2000,
            'want_ret' => false
        ),
        array(
            'val' => '2000-12-31',
            'min_year' => 2000,
            'max_year' => 2000,
            'want_ret' => true
        ),
        array(
            'val' => '',
            'min_year' => 1990,
            'max_year' => 2000,
            'want_ret' => false
        ),
        array(
            'val' => '2000-12-31',
            'min_year' => 2000,
            'max_year' => 1999,
            'want_ret' => false,
            'want_exception' => 'common validator: min year > max year invalid'
        ),
    );

    foreach($cases as $case)
    {
        try
        {
            $ret = \Validator\CommonValidator::date($case['val'], $case['min_year'], $case['max_year']);
            assert($case['want_ret']==$ret);
        }
        catch(\Throwable $e)
        {
            assert($case['want_exception']==$e->getMessage());
        }
    }
}

// 测试 datetime
function TestDatetime()
{
    $cases = array(
        array(
            'val' => '2024-01-01 12:00:00',
            'want_ret' => true
        ),
        array(
            'val' => '2023-02-29 12:00:00',
            'want_ret' => false
        ),
        array(
            'val' => '2048-02-29 12:00:00',
            'want_ret' => true
        ),
        array(
            'val' => '',
            'want_ret' => false
        ),
        array(
            'val' => 'abcdefg',
            'want_ret' => false
        ),
    );

    foreach($cases as $case)
    {
        $ret = \Validator\CommonValidator::datetime($case['val']);
        assert($case['want_ret']==$ret);
    }
}

// 测试 version
function TestVersion()
{
    $cases = array(
        array(
            'val' => '1.0.0',
            'want_ret' => true
        ),
        array(
            'val' => '999.99.99',
            'want_ret' => true
        ),
        array(
            'val' => '1.0.0.0',
            'want_ret' => false
        ),
        array(
            'val' => '1.0.0.1',
            'want_ret' => true
        ),
        array(
            'val' => '999.99.99.99',
            'want_ret' => true
        ),
        array(
            'val' => 'abc',
            'want_ret' => false
        ),
        array(
            'val' => '2.0',
            'want_ret' => false
        ),
    );

    foreach($cases as $case)
    {
        $ret = \Validator\CommonValidator::version($case['val']);
        assert($case['want_ret']==$ret);
    }
}

// 测试 longitude
function TestLongitude()
{
    $cases = array(
        array(
            'val' => 180,
            'want_ret' => true
        ),
        array(
            'val' => -180,
            'want_ret' => true
        ),
        array(
            'val' => 113.327782,
            'want_ret' => true
        ),
        array(
            'val' => 180.01,
            'want_ret' => false
        ),
        array(
            'val' => -180.01,
            'want_ret' => false
        ),
    );

    foreach($cases as $case)
    {
        $ret = \Validator\CommonValidator::longitude($case['val']);
        assert($case['want_ret']==$ret);
    }
}

// 测试 latitude
function TestLatitude()
{
    $cases = array(
        array(
            'val' => 90,
            'want_ret' => true
        ),
        array(
            'val' => -90,
            'want_ret' => true
        ),
        array(
            'val' => 23.137202,
            'want_ret' => true
        ),
        array(
            'val' => 90.01,
            'want_ret' => false
        ),
        array(
            'val' => -90.01,
            'want_ret' => false
        ),
    );

    foreach($cases as $case)
    {
        $ret = \Validator\CommonValidator::latitude($case['val']);
        assert($case['want_ret']==$ret);
    }
}

// 测试 fileExtension
function TestFileExtension()
{
    $cases = array(
        array(
            'val' => 'a.jpg',
            'allow_extensions' => ['jpg', 'gif', 'png'],
            'want_ret' => true
        ),
        array(
            'val' => 'b.GIF',
            'allow_extensions' => ['gif'],
            'want_ret' => true
        ),
        array(
            'val' => 'a.jpg',
            'allow_extensions' => ['gif', 'png'],
            'want_ret' => false
        ),
        array(
            'val' => 'a.jpg',
            'allow_extensions' => [],
            'want_ret' => false
        ),
        array(
            'val' => '_jpg',
            'allow_extensions' => ['jpg'],
            'want_ret' => false
        ),
    );

    foreach($cases as $case)
    {
        $ret = \Validator\CommonValidator::fileExtension($case['val'], $case['allow_extensions']);
        assert($case['want_ret']==$ret);
    }
}