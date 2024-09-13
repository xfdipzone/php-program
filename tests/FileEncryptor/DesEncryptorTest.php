<?php declare(strict_types=1);
namespace Tests\FileEncryptor;

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-file-encryptor\FileEncryptor\DesEncryptor
 *
 * @author fdipzone
 */
final class DesEncryptorTest extends TestCase
{
    /**
     * @covers \FileEncryptor\DesEncryptor::name
     */
    public function testName()
    {
        $encrypt_key = '123456';
        $des_encryptor = new \FileEncryptor\DesEncryptor($encrypt_key);
        $this->assertEquals('des encryptor', $des_encryptor->name());
    }

    /**
     * @covers \FileEncryptor\DesEncryptor::cipherAlgo
     */
    public function testCipherAlgo()
    {
        $encrypt_key = '123456';
        $des_encryptor = new \FileEncryptor\DesEncryptor($encrypt_key);
        $this->assertEquals('DES', $des_encryptor->cipherAlgo());
    }

    /**
     * @covers \FileEncryptor\DesEncryptor::iv
     */
    public function testIv()
    {
        $encrypt_key = '123456';
        $des_encryptor = new \FileEncryptor\DesEncryptor($encrypt_key);
        $this->assertTrue(strlen($des_encryptor->iv())==8);
    }
}