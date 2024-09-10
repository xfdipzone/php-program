<?php declare(strict_types=1);
namespace Tests\FileEncryptor;

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-file-encryptor\FileEncryptor\XorEncryptor
 *
 * @author fdipzone
 */
final class XorEncryptorTest extends TestCase
{
    // 定义用例用到的测试文件
    private static $source_file = '/tmp/source_file.txt';
    private static $encrypt_file = '/tmp/encrypt_file.txt';
    private static $decrypt_file = '/tmp/decrypt_file.txt';

    // 初始化测试文件
    public static function setUpBeforeClass()
    {
        file_put_contents(self::$source_file, 'abcdef');
    }

    // 删除测试文件
    public static function tearDownAfterClass()
    {
        if(file_exists(self::$source_file))
        {
            unlink(self::$source_file);
        }

        if(file_exists(self::$encrypt_file))
        {
            unlink(self::$encrypt_file);
        }

        if(file_exists(self::$decrypt_file))
        {
            unlink(self::$decrypt_file);
        }
    }

    /**
     * @covers \FileEncryptor\XorEncryptor::__construct
     */
    public function testConstruct()
    {
        $encrypt_key = '123456';
        $xor_encryptor = new \FileEncryptor\XorEncryptor($encrypt_key);
        $this->assertEquals('FileEncryptor\XorEncryptor', get_class($xor_encryptor));
    }

    /**
     * @covers \FileEncryptor\XorEncryptor::__construct
     */
    public function testConstructException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('xor encryptor: encrypt key is empty');
        new \FileEncryptor\XorEncryptor('');
    }

    /**
     * @covers \FileEncryptor\XorEncryptor::encrypt
     * @covers \FileEncryptor\XorEncryptor::decrypt
     */
    public function testEncryptAndDecrypt()
    {
        $encrypt_key = '123456';
        $xor_encryptor = new \FileEncryptor\XorEncryptor($encrypt_key);

        // encrypt
        $ret = $xor_encryptor->encrypt(self::$source_file, self::$encrypt_file);
        $this->assertTrue($ret);
        $this->assertSame(strlen(file_get_contents(self::$source_file)), strlen(file_get_contents(self::$encrypt_file)));

        // decrypt
        $ret = $xor_encryptor->decrypt(self::$encrypt_file, self::$decrypt_file);
        $this->assertTrue($ret);
        $this->assertSame(strlen(file_get_contents(self::$encrypt_file)), strlen(file_get_contents(self::$decrypt_file)));
        $this->assertEquals(file_get_contents(self::$source_file), file_get_contents(self::$decrypt_file));
    }

    /**
     * @covers \FileEncryptor\XorEncryptor::encrypt
     */
    public function testEncryptParameterSourceFileException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('xor encryptor: source file not exists');

        $encrypt_key = '123456';
        $xor_encryptor = new \FileEncryptor\XorEncryptor($encrypt_key);
        $xor_encryptor->encrypt('/tmp/not_exists_file.txt', self::$encrypt_file);
    }

    /**
     * @covers \FileEncryptor\XorEncryptor::encrypt
     */
    public function testEncryptParameterEncryptFileException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('xor encryptor: encrypt file is empty');

        $encrypt_key = '123456';
        $xor_encryptor = new \FileEncryptor\XorEncryptor($encrypt_key);
        $xor_encryptor->encrypt(self::$source_file, '');
    }

    /**
     * @covers \FileEncryptor\XorEncryptor::decrypt
     */
    public function testDecryptParameterEncryptFileException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('xor encryptor: encrypt file not exists');

        $encrypt_key = '123456';
        $xor_encryptor = new \FileEncryptor\XorEncryptor($encrypt_key);
        $xor_encryptor->decrypt('/tmp/not_exists_file.txt', self::$decrypt_file);
    }

    /**
     * @covers \FileEncryptor\XorEncryptor::decrypt
     */
    public function testDecryptParameterDecryptFileException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('xor encryptor: decrypt file is empty');

        $encrypt_key = '123456';
        $xor_encryptor = new \FileEncryptor\XorEncryptor($encrypt_key);
        $xor_encryptor->decrypt(self::$encrypt_file, '');
    }

    /**
     * @covers \FileEncryptor\XorEncryptor::xorEncrypt
     */
    public function testXorEncrypt()
    {
        $encrypt_key = '123456';
        $xor_encryptor = new \FileEncryptor\XorEncryptor($encrypt_key);

        $encrypt_file = '/tmp/'.date('YmdHis').'/encrypt_file.txt';
        $decrypt_file = '/tmp/'.date('YmdHis').'/decrypt_file.txt';

        // encrypt
        $ret = \Tests\Utils\PHPUnitExtension::callMethod($xor_encryptor, 'xorEncrypt', [self::$source_file, $encrypt_file]);
        $this->assertTrue($ret);
        $this->assertSame(strlen(file_get_contents(self::$source_file)), strlen(file_get_contents($encrypt_file)));

        // decrypt
        $ret = \Tests\Utils\PHPUnitExtension::callMethod($xor_encryptor, 'xorEncrypt', [$encrypt_file, $decrypt_file]);
        $this->assertTrue($ret);
        $this->assertSame(strlen(file_get_contents($encrypt_file)), strlen(file_get_contents($decrypt_file)));
        $this->assertEquals(file_get_contents(self::$source_file), file_get_contents($decrypt_file));

        // exception
        $ret = \Tests\Utils\PHPUnitExtension::callMethod($xor_encryptor, 'xorEncrypt', ['/tmp/not_exists_file.txt', $decrypt_file]);
        $this->assertFalse($ret);
    }
}