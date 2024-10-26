<?php declare(strict_types=1);
namespace Tests\Mail;

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-mailer\Mail\Mailer
 *
 * @author fdipzone
 */
final class MailerTest extends TestCase
{
    /**
     * @covers \Mail\Mailer::__construct
     */
    public function testConstruct()
    {
        $smtp_host = 'smtp.mxhichina.com';
        $smtp_username = 'fdipzone';
        $smtp_password = '123456abc!@#$';

        $server_config = new \Mail\ServerConfig($smtp_host, $smtp_username, $smtp_password);

        $mailer = new \Mail\Mailer($server_config);
        $this->assertEquals('Mail\Mailer', get_class($mailer));
    }
}