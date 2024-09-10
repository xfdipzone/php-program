<?php declare(strict_types=1);
namespace Tests\FileEncryptor;

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-file-encryptor\FileEncryptor\Factory
 *
 * @author fdipzone
 */
final class FactoryTest extends TestCase
{
    /**
     * @covers \FileEncryptor\Factory::make
     */
    public function testMake()
    {
        $encrypt_key = '123456';

        $xor_encryptor = \FileEncryptor\Factory::make(\FileEncryptor\Type::XOR, $encrypt_key);
        $this->assertEquals('FileEncryptor\XorEncryptor', get_class($xor_encryptor));

        $aes_encryptor = \FileEncryptor\Factory::make(\FileEncryptor\Type::AES, $encrypt_key);
        $this->assertEquals('FileEncryptor\AesEncryptor', get_class($aes_encryptor));
    }

    /**
     * @covers \FileEncryptor\Factory::make
     */
    public function testMakeException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('file encryptor factory: type not_exists_type not exists');

        $type = 'not_exists_type';
        $encrypt_key = '123456';
        \FileEncryptor\Factory::make($type, $encrypt_key);
    }

    /**
     * @covers \FileEncryptor\Factory::getEncryptorClass
     */
    public function testGetEncryptorClass()
    {
        $xor_encryptor_class = \FileEncryptor\Factory::getEncryptorClass(\FileEncryptor\Type::XOR);
        $this->assertEquals('\FileEncryptor\XorEncryptor', $xor_encryptor_class);

        $aes_encryptor_class = \FileEncryptor\Factory::getEncryptorClass(\FileEncryptor\Type::AES);
        $this->assertEquals('\FileEncryptor\AesEncryptor', $aes_encryptor_class);
    }

    /**
     * @covers \FileEncryptor\Factory::getEncryptorClass
     */
    public function testGetEncryptorClassException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('file encryptor factory: type not_exists_type not exists');

        $type = 'not_exists_type';
        \FileEncryptor\Factory::getEncryptorClass($type);
    }
}