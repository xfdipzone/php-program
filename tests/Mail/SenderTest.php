<?php declare(strict_types=1);
namespace Tests\Mail;

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-mailer\Mail\Sender
 *
 * @author fdipzone
 */
final class SenderTest extends TestCase
{
    /**
     * @covers \Mail\Sender::__construct
     */
    public function testConstruct()
    {
        $from_email = 'technology@zone.com';
        $from_name = 'fdipzone';
        $sender_email = 'promotion@zone.com';
        $sender = new \Mail\Sender($from_email, $from_name, $sender_email);
        $this->assertEquals('Mail\Sender', get_class($sender));
    }

    /**
     * @covers \Mail\Sender::__construct
     */
    public function testConstructFromEmailEmptyException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('mailer sender: from email is empty');

        $from_email = '';
        new \Mail\Sender($from_email);
    }

    /**
     * @covers \Mail\Sender::__construct
     */
    public function testConstructFromEmailInvalidException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('mailer sender: from email is invalid');

        $from_email = 'good@good';
        new \Mail\Sender($from_email);
    }

    /**
     * @covers \Mail\Sender::__construct
     */
    public function testConstructSenderEmailInvalidException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('mailer sender: sender email is invalid');

        $from_email = 'technology@zone.com';
        $sender_email = 'good@good';
        new \Mail\Sender($from_email, '', $sender_email);
    }

    /**
     * @covers \Mail\Sender::__construct
     * @covers \Mail\Sender::fromEmail
     * @covers \Mail\Sender::fromName
     * @covers \Mail\Sender::senderEmail
     */
    public function testGet()
    {
        $from_email = 'technology@zone.com';
        $from_name = 'fdipzone';
        $sender_email = 'promotion@zone.com';
        $sender = new \Mail\Sender($from_email, $from_name, $sender_email);
        $this->assertEquals($from_email, $sender->fromEmail());
        $this->assertEquals($from_name, $sender->fromName());
        $this->assertEquals($sender_email, $sender->senderEmail());

        // 测试不设置发件人名称与发件人电子邮箱
        $sender = new \Mail\Sender($from_email);
        $this->assertEquals($from_email, $sender->fromEmail());
        $this->assertEquals($from_email, $sender->fromName());
        $this->assertEquals('', $sender->senderEmail());
    }
}