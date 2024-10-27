<?php declare(strict_types=1);
namespace Tests\Mail;

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-mailer\Mail\Attachment
 *
 * @author fdipzone
 */
final class AttachmentTest extends TestCase
{
    // 定义用例用到的测试文件
    private static $attachment_file = '/tmp/attachment.txt';

    // 初始化测试文件
    public static function setUpBeforeClass()
    {
        file_put_contents(self::$attachment_file, 'attachment file');
    }

    // 删除测试文件
    public static function tearDownAfterClass()
    {
        if(file_exists(self::$attachment_file))
        {
            unlink(self::$attachment_file);
        }
    }

    /**
     * @covers \Mail\Attachment::__construct
     */
    public function testConstruct()
    {
        $file = self::$attachment_file;
        $name = '附件.txt';
        $attachment = new \Mail\Attachment($file, $name);
        $this->assertEquals('Mail\Attachment', get_class($attachment));
    }

    /**
     * @covers \Mail\Attachment::__construct
     */
    public function testConstructFileEmptyException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('mailer attachment: file is empty');

        $file = '';
        new \Mail\Attachment($file);
    }

    /**
     * @covers \Mail\Attachment::__construct
     */
    public function testConstructFileNotExistsException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('mailer attachment: file not exists');

        $file = '/tmp/not_exists_file.txt';
        new \Mail\Attachment($file);
    }

    /**
     * @covers \Mail\Attachment::__construct
     * @covers \Mail\Attachment::file
     * @covers \Mail\Attachment::name
     */
    public function testGet()
    {
        $file = self::$attachment_file;
        $name = '附件.txt';
        $attachment = new \Mail\Attachment($file, $name);
        $this->assertEquals($file, $attachment->file());
        $this->assertEquals($name, $attachment->name());

        // 测试不设置附件名称
        $attachment = new \Mail\Attachment($file);
        $this->assertEquals($file, $attachment->file());
        $this->assertEquals(basename($file), $attachment->name());
    }
}