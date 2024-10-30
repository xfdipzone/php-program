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

    /**
     * @covers \Mail\Mailer::setSender
     * @covers \Mail\Mailer::sender
     */
    public function testSender()
    {
        $smtp_host = 'smtp.mxhichina.com';
        $smtp_username = 'fdipzone';
        $smtp_password = '123456abc!@#$';
        $server_config = new \Mail\ServerConfig($smtp_host, $smtp_username, $smtp_password);
        $mailer = new \Mail\Mailer($server_config);

        $from_email = 'technology@zone.com';
        $from_name = 'fdipzone';
        $sender = new \Mail\Sender($from_email, $from_name);

        $mailer->setSender($sender);
        $mailer_sender = $mailer->sender();
        $this->assertEquals($from_email, $mailer_sender->fromEmail());
        $this->assertEquals($from_name, $mailer_sender->fromName());
        $this->assertEquals('', $mailer_sender->senderEmail());
    }

    /**
     * @covers \Mail\Mailer::addRecipient
     * @covers \Mail\Mailer::recipients
     */
    public function testRecipient()
    {
        $smtp_host = 'smtp.mxhichina.com';
        $smtp_username = 'fdipzone';
        $smtp_password = '123456abc!@#$';
        $server_config = new \Mail\ServerConfig($smtp_host, $smtp_username, $smtp_password);
        $mailer = new \Mail\Mailer($server_config);

        $email = 'technology@zone.com';
        $name = 'fdipzone';
        $recipient = new \Mail\Recipient($email, $name);

        $mailer->addRecipient($recipient);
        $mailer_recipients = $mailer->recipients();
        $this->assertSame(1, count($mailer_recipients));
        $this->assertEquals($email, $mailer_recipients[$email]->email());
        $this->assertEquals($name, $mailer_recipients[$email]->name());
    }

    /**
     * @covers \Mail\Mailer::addCcRecipient
     * @covers \Mail\Mailer::ccRecipients
     */
    public function testCcRecipient()
    {
        $smtp_host = 'smtp.mxhichina.com';
        $smtp_username = 'fdipzone';
        $smtp_password = '123456abc!@#$';
        $server_config = new \Mail\ServerConfig($smtp_host, $smtp_username, $smtp_password);
        $mailer = new \Mail\Mailer($server_config);

        $email = 'technology@zone.com';
        $name = 'fdipzone';
        $recipient = new \Mail\Recipient($email, $name);

        $mailer->addCcRecipient($recipient);
        $mailer_cc_recipients = $mailer->ccRecipients();
        $this->assertSame(1, count($mailer_cc_recipients));
        $this->assertEquals($email, $mailer_cc_recipients[$email]->email());
        $this->assertEquals($name, $mailer_cc_recipients[$email]->name());
    }

    /**
     * @covers \Mail\Mailer::addBccRecipient
     * @covers \Mail\Mailer::bccRecipients
     */
    public function testBccRecipient()
    {
        $smtp_host = 'smtp.mxhichina.com';
        $smtp_username = 'fdipzone';
        $smtp_password = '123456abc!@#$';
        $server_config = new \Mail\ServerConfig($smtp_host, $smtp_username, $smtp_password);
        $mailer = new \Mail\Mailer($server_config);

        $email = 'technology@zone.com';
        $name = 'fdipzone';
        $recipient = new \Mail\Recipient($email, $name);

        $mailer->addBccRecipient($recipient);
        $mailer_bcc_recipients = $mailer->bccRecipients();
        $this->assertSame(1, count($mailer_bcc_recipients));
        $this->assertEquals($email, $mailer_bcc_recipients[$email]->email());
        $this->assertEquals($name, $mailer_bcc_recipients[$email]->name());
    }

    /**
     * @covers \Mail\Mailer::addAttachment
     * @covers \Mail\Mailer::attachments
     */
    public function testAttachment()
    {
        $smtp_host = 'smtp.mxhichina.com';
        $smtp_username = 'fdipzone';
        $smtp_password = '123456abc!@#$';
        $server_config = new \Mail\ServerConfig($smtp_host, $smtp_username, $smtp_password);
        $mailer = new \Mail\Mailer($server_config);

        $attachment_file = '/tmp/attachment.txt';
        file_put_contents($attachment_file, 'attachment file');

        $name = '附件.txt';
        $attachment = new \Mail\Attachment($attachment_file, $name);

        $mailer->addAttachment($attachment);
        $mailer_attachments = $mailer->attachments();
        $this->assertSame(1, count($mailer_attachments));
        $this->assertEquals($attachment_file, $mailer_attachments[$attachment_file]->file());
        $this->assertEquals($name, $mailer_attachments[$attachment_file]->name());

        if(file_exists($attachment_file))
        {
            unlink($attachment_file);
        }
    }
}