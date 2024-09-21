<?php declare(strict_types=1);
namespace Tests\Validator;

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-validator\Validator\CommonValidator
 *
 * @author fdipzone
 */
final class CommonValidatorTest extends TestCase
{
    /**
     * @covers \Validator\CommonValidator::empty
     */
    public function testEmpty()
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
            $this->assertEquals($case['want_ret'], $ret);
        }
    }

    /**
     * @covers \Validator\CommonValidator::length
     */
    public function testLength()
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
        );

        foreach($cases as $case)
        {
            $ret = \Validator\CommonValidator::length($case['val'], $case['min_length'], $case['max_length']);
            $this->assertEquals($case['want_ret'], $ret);
        }
    }

    /**
     * @covers \Validator\CommonValidator::length
     */
    public function testLengthException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('common validator: min length > max length invalid');

        \Validator\CommonValidator::length('abc', 6, 5);
    }

    /**
     * @covers \Validator\CommonValidator::number
     */
    public function testNumber()
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
            $this->assertEquals($case['want_ret'], $ret);
        }
    }

    /**
     * @covers \Validator\CommonValidator::httpUrl
     */
    public function testHttpUrl()
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
            $this->assertEquals($case['want_ret'], $ret);
        }
    }

    /**
     * @covers \Validator\CommonValidator::domain
     */
    public function testDomain()
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
            $this->assertEquals($case['want_ret'], $ret);
        }
    }

    /**
     * @covers \Validator\CommonValidator::email
     */
    public function testEmail()
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
            $this->assertEquals($case['want_ret'], $ret);
        }
    }

    /**
     * @covers \Validator\CommonValidator::date
     */
    public function testDate()
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
        );

        foreach($cases as $case)
        {
            $ret = \Validator\CommonValidator::date($case['val'], $case['min_year'], $case['max_year']);
            $this->assertEquals($case['want_ret'], $ret);
        }
    }

    /**
     * @covers \Validator\CommonValidator::date
     */
    public function testDateException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('common validator: min year > max year invalid');

        \Validator\CommonValidator::date('2000-12-31', 2000, 1999);
    }

    /**
     * @covers \Validator\CommonValidator::datetime
     */
    public function testDatetime()
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
            $this->assertEquals($case['want_ret'], $ret);
        }
    }

    /**
     * @covers \Validator\CommonValidator::version
     */
    public function testVersion()
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
            $this->assertEquals($case['want_ret'], $ret);
        }
    }

    /**
     * @covers \Validator\CommonValidator::longitude
     */
    public function testLongitude()
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
            $this->assertEquals($case['want_ret'], $ret);
        }
    }

    /**
     * @covers \Validator\CommonValidator::latitude
     */
    public function testLatitude()
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
            $this->assertEquals($case['want_ret'], $ret);
        }
    }

    /**
     * @covers \Validator\CommonValidator::fileExtension
     */
    public function testFileExtension()
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
            $this->assertEquals($case['want_ret'], $ret);
        }
    }
}