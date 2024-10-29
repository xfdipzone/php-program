<?php declare(strict_types=1);
namespace Tests\Mail;

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-mailer\Mail\Recipient
 *
 * @author fdipzone
 */
final class RecipientTest extends TestCase
{
    /**
     * @covers \Mail\Recipient::__construct
     */
    public function testConstruct()
    {
        $email = 'technology@zone.com';
        $name = 'fdipzone';
        $recipient = new \Mail\Recipient($email, $name);
        $this->assertEquals('Mail\Recipient', get_class($recipient));
    }

    /**
     * @covers \Mail\Recipient::__construct
     */
    public function testConstructEmailEmptyException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('mailer recipient: email is empty');

        $email = '';
        new \Mail\Recipient($email);
    }

    /**
     * @covers \Mail\Recipient::__construct
     */
    public function testConstructEmailInvalidException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('mailer recipient: email is invalid');

        $email = 'good@good';
        new \Mail\Recipient($email);
    }

    /**
     * @covers \Mail\Recipient::__construct
     * @covers \Mail\Recipient::email
     * @covers \Mail\Recipient::name
     */
    public function testGet()
    {
        $email = 'technology@zone.com';
        $name = 'fdipzone';
        $recipient = new \Mail\Recipient($email, $name);
        $this->assertEquals($email, $recipient->email());
        $this->assertEquals($name, $recipient->name());

        // 测试不设置收件人名称
        $recipient = new \Mail\Recipient($email);
        $this->assertEquals($email, $recipient->email());
        $this->assertEquals($email, $recipient->name());
    }
}