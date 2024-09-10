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
    // 定义用例用到的测试文件
    private static $source_file = '/tmp/source_file.txt';
    private static $encrypt_file;
    private static $decrypt_file;

    // 初始化测试文件
    public static function setUpBeforeClass()
    {
        $date_folder = date('YmdHis');
        self::$encrypt_file = sprintf('/tmp/%s%d/encrypt_file.txt', $date_folder, 1);
        self::$decrypt_file = sprintf('/tmp/%s%d/decrypt_file.txt', $date_folder, 2);

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
     * @covers \FileEncryptor\AesEncryptor::__construct
     */
    public function testConstruct()
    {
        $encrypt_key = '123456';
        $aes_encryptor = new \FileEncryptor\AesEncryptor($encrypt_key);
        $this->assertEquals('FileEncryptor\AesEncryptor', get_class($aes_encryptor));
    }

    /**
     * @covers \FileEncryptor\AesEncryptor::__construct
     */
    public function testConstructException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('aes encryptor: encrypt key is empty');
        new \FileEncryptor\AesEncryptor('');
    }

    /**
     * @covers \FileEncryptor\AesEncryptor::encrypt
     * @covers \FileEncryptor\AesEncryptor::decrypt
     */
    public function testEncryptAndDecrypt()
    {
        $encrypt_key = '123456';
        $aes_encryptor = new \FileEncryptor\AesEncryptor($encrypt_key);

        // encrypt
        $ret = $aes_encryptor->encrypt(self::$source_file, self::$encrypt_file);
        $this->assertTrue($ret);

        // decrypt
        $ret = $aes_encryptor->decrypt(self::$encrypt_file, self::$decrypt_file);
        $this->assertTrue($ret);
        $this->assertSame(strlen(file_get_contents(self::$source_file)), strlen(file_get_contents(self::$decrypt_file)));
        $this->assertEquals(file_get_contents(self::$source_file), file_get_contents(self::$decrypt_file));
    }

    /**
     * @covers \FileEncryptor\AesEncryptor::encrypt
     */
    public function testEncryptParameterSourceFileException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('aes encryptor: source file not exists');

        $encrypt_key = '123456';
        $aes_encryptor = new \FileEncryptor\AesEncryptor($encrypt_key);
        $aes_encryptor->encrypt('/tmp/not_exists_file.txt', self::$encrypt_file);
    }

    /**
     * @covers \FileEncryptor\AesEncryptor::encrypt
     */
    public function testEncryptParameterEncryptFileException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('aes encryptor: encrypt file is empty');

        $encrypt_key = '123456';
        $aes_encryptor = new \FileEncryptor\AesEncryptor($encrypt_key);
        $aes_encryptor->encrypt(self::$source_file, '');
    }

    /**
     * @covers \FileEncryptor\AesEncryptor::encrypt
     */
    public function testEncryptException()
    {
        $encrypt_key = '123456';
        $encrypt_file = '/tmp'.str_pad('a', 255).'.txt';
        $aes_encryptor = new \FileEncryptor\AesEncryptor($encrypt_key);
        $ret = $aes_encryptor->encrypt(self::$source_file, $encrypt_file);
        $this->assertFalse($ret);
    }

    /**
     * @covers \FileEncryptor\AesEncryptor::decrypt
     */
    public function testDecryptParameterEncryptFileException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('aes encryptor: encrypt file not exists');

        $encrypt_key = '123456';
        $aes_encryptor = new \FileEncryptor\AesEncryptor($encrypt_key);
        $aes_encryptor->decrypt('/tmp/not_exists_file.txt', self::$decrypt_file);
    }

    /**
     * @covers \FileEncryptor\AesEncryptor::decrypt
     */
    public function testDecryptParameterDecryptFileException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('aes encryptor: decrypt file is empty');

        $encrypt_key = '123456';
        $aes_encryptor = new \FileEncryptor\AesEncryptor($encrypt_key);
        $aes_encryptor->decrypt(self::$encrypt_file, '');
    }

    /**
     * @covers \FileEncryptor\AesEncryptor::decrypt
     */
    public function testDecryptException()
    {
        $encrypt_key = '123456';
        $decrypt_file = '/tmp'.str_pad('a', 255).'.txt';
        $aes_encryptor = new \FileEncryptor\AesEncryptor($encrypt_key);
        $ret = $aes_encryptor->decrypt(self::$encrypt_file, $decrypt_file);
        $this->assertFalse($ret);
    }
}