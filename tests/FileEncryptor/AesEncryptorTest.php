<?php declare(strict_types=1);
namespace Tests\FileEncryptor;

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-file-encryptor\FileEncryptor\AesEncryptor
 *
 * @author fdipzone
 */
final class AesEncryptorTest extends TestCase
{
    /**
     * @covers \FileEncryptor\AesEncryptor::name
     */
    public function testName()
    {
        $encrypt_key = '123456';
        $aes_encryptor = new \FileEncryptor\AesEncryptor($encrypt_key);
        $this->assertEquals('aes encryptor', $aes_encryptor->name());
    }

    /**
     * @covers \FileEncryptor\AesEncryptor::cipherAlgo
     */
    public function testCipherAlgo()
    {
        $encrypt_key = '123456';
        $aes_encryptor = new \FileEncryptor\AesEncryptor($encrypt_key);
        $this->assertEquals('AES-256-CBC', $aes_encryptor->cipherAlgo());
    }

    /**
     * @covers \FileEncryptor\AesEncryptor::iv
     */
    public function testIv()
    {
        $encrypt_key = '123456';
        $aes_encryptor = new \FileEncryptor\AesEncryptor($encrypt_key);
        $this->assertTrue(strlen($aes_encryptor->iv())==16);
    }
}