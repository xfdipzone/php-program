<?php declare(strict_types=1);
namespace Tests\Csrf;

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-csrf\Csrf\CryptoUtils
 *
 * @author fdipzone
 */
final class CryptoUtilsTest extends TestCase
{
    /**
     * @covers \Csrf\CryptoUtils::encrypt
     * @covers \Csrf\CryptoUtils::decrypt
     */
    public function testEncryptAndDecrypt()
    {
        $source_string = 'I am programmer';
        $secret = 'abc123';

        // 加密
        $encrypt_string = \Csrf\CryptoUtils::encrypt($source_string, $secret);
        $this->assertTrue($encrypt_string!='');

        // 解密
        $decrypt_string = \Csrf\CryptoUtils::decrypt($encrypt_string, $secret);
        $this->assertEquals($source_string, $decrypt_string);
    }

    /**
     * @covers \Csrf\CryptoUtils::encrypt
     * @dataProvider encryptExceptionCases
     */
    public function testEncryptException($func, $exception_message)
    {
        $this->expectException(\Csrf\Exception\CryptoException::class);
        $this->expectExceptionMessage($exception_message);
        $func();
    }

    // 测试 encrypt 异常
    public function encryptExceptionCases()
    {
        // 异常情况
        $exception_cases = array(
            array(
                function()
                {
                    $source_string = '';
                    $secret = 'abc123';
                    \Csrf\CryptoUtils::encrypt($source_string, $secret);
                },
                'source string is empty'
            ),
            array(
                function()
                {
                    $source_string = 'I am programmer';
                    $secret = '';
                    \Csrf\CryptoUtils::encrypt($source_string, $secret);
                },
                'secret is empty'
            ),
        );

        return $exception_cases;
    }

    /**
     * @covers \Csrf\CryptoUtils::decrypt
     * @dataProvider decryptExceptionCases
     */
    public function testDecryptException($func, $exception_message)
    {
        $this->expectException(\Csrf\Exception\CryptoException::class);
        $this->expectExceptionMessage($exception_message);
        $func();
    }

    // 测试 decrypt 异常
    public function decryptExceptionCases()
    {
        // 异常情况
        $exception_cases = array(
            array(
                function()
                {
                    $encrypt_string = '';
                    $secret = 'abc123';
                    \Csrf\CryptoUtils::decrypt($encrypt_string, $secret);
                },
                'encrypt string is empty'
            ),
            array(
                function()
                {
                    $encrypt_string = 'encrypt string';
                    $secret = '';
                    \Csrf\CryptoUtils::decrypt($encrypt_string, $secret);
                },
                'secret is empty'
            ),
        );

        return $exception_cases;
    }
}