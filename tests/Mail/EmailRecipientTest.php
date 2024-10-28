<?php declare(strict_types=1);
namespace Tests\Mail;

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-mailer\Mail\EmailRecipient
 *
 * @author fdipzone
 */
final class EmailRecipientTest extends TestCase
{
    /**
     * @covers \Mail\EmailRecipient::__construct
     */
    public function testConstruct()
    {
        $email = 'technology@zone.com';
        $name = 'fdipzone';
        $email_recipient = new \Mail\EmailRecipient($email, $name);
        $this->assertEquals('Mail\EmailRecipient', get_class($email_recipient));
    }

    /**
     * @covers \Mail\EmailRecipient::__construct
     */
    public function testConstructEmailEmptyException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('mailer email recipient: email is empty');

        $email = '';
        new \Mail\EmailRecipient($email);
    }

    /**
     * @covers \Mail\EmailRecipient::__construct
     */
    public function testConstructEmailInvalidException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('mailer email recipient: email is invalid');

        $email = 'good@good';
        new \Mail\EmailRecipient($email);
    }

    /**
     * @covers \Mail\EmailRecipient::__construct
     * @covers \Mail\EmailRecipient::email
     * @covers \Mail\EmailRecipient::name
     */
    public function testGet()
    {
        $email = 'technology@zone.com';
        $name = 'fdipzone';
        $email_recipient = new \Mail\EmailRecipient($email, $name);
        $this->assertEquals($email, $email_recipient->email());
        $this->assertEquals($name, $email_recipient->name());

        // 测试不设置收件人名称
        $email_recipient = new \Mail\EmailRecipient($email);
        $this->assertEquals($email, $email_recipient->email());
        $this->assertEquals($email, $email_recipient->name());
    }

    /**
     * @covers \Mail\EmailRecipient::validateEmail
     */
    public function testValidateEmail()
    {
        $email = 'technology@zone.com';
        $name = 'fdipzone';
        $email_recipient = new \Mail\EmailRecipient($email, $name);

        $ret = \Tests\Utils\PHPUnitExtension::callMethod($email_recipient, 'validateEmail', [$email]);
        $this->assertTrue($ret);

        $email = 'good@good';
        $ret = \Tests\Utils\PHPUnitExtension::callMethod($email_recipient, 'validateEmail', [$email]);
        $this->assertFalse($ret);
    }
}