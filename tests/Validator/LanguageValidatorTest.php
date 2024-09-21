<?php declare(strict_types=1);
namespace Tests\Validator;

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-validator\Validator\LanguageValidator
 *
 * @author fdipzone
 */
final class LanguageValidatorTest extends TestCase
{
    /**
     * @covers \Validator\LanguageValidator::isEnglish
     */
    public function testIsEnglish()
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
            $this->assertEquals($case['want_ret'], $ret);
        }
    }

    /**
     * @covers \Validator\LanguageValidator::isChinese
     */
    public function testIsChinese()
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
            $this->assertEquals($case['want_ret'], $ret);
        }
    }

    /**
     * @covers \Validator\LanguageValidator::isThai
     */
    public function testIsThai()
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
            $this->assertEquals($case['want_ret'], $ret);
        }
    }

    /**
     * @covers \Validator\LanguageValidator::isVietnamese
     */
    public function testIsVietnamese()
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
            $this->assertEquals($case['want_ret'], $ret);
        }
    }
}