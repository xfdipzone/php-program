<?php declare(strict_types=1);
namespace Tests\Validator;

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-validator\Validator\IDNumberValidator
 *
 * @author fdipzone
 */
final class IDNumberValidatorTest extends TestCase
{
    /**
     * @covers \Validator\IDNumberValidator::idCard
     */
    public function testIDCard()
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
            $this->assertEquals($case['want_ret'], $ret);
        }
    }

    /**
     * @covers \Validator\IDNumberValidator::licensePlateNumber
     */
    public function testLicensePlateNumber()
    {
        $cases = array(
            array(
                'val' => '京AD12345',
                'want_ret' => true
            ),
            array(
                'val' => '粤AF12345',
                'want_ret' => true
            ),
            array(
                'val' => '粤B12345D',
                'want_ret' => true
            ),
            array(
                'val' => '渝A1234挂',
                'want_ret' => true
            ),
            array(
                'val' => 'ABC1234',
                'want_ret' => false
            ),
            array(
                'val' => '京AE12345',
                'want_ret' => false
            ),
            array(
                'val' => '辽A12345D1',
                'want_ret' => false
            ),
            array(
                'val' => '沪AFE2345',
                'want_ret' => true
            ),
        );

        foreach($cases as $case)
        {
            $ret = \Validator\IDNumberValidator::licensePlateNumber($case['val']);
            $this->assertEquals($case['want_ret'], $ret);
        }
    }
}