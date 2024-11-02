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

    /**
     * @covers \Mail\Mailer::setIsHtml
     * @covers \Mail\Mailer::isHtml
     */
    public function testIsHtml()
    {
        $smtp_host = 'smtp.mxhichina.com';
        $smtp_username = 'fdipzone';
        $smtp_password = '123456abc!@#$';
        $server_config = new \Mail\ServerConfig($smtp_host, $smtp_username, $smtp_password);
        $mailer = new \Mail\Mailer($server_config);

        // 默认
        $this->assertTrue($mailer->isHtml());

        // 设置使用 html 格式发送
        $mailer->setIsHtml(true);
        $this->assertTrue($mailer->isHtml());

        // 设置不使用 html 格式发送
        $mailer->setIsHtml(false);
        $this->assertFalse($mailer->isHtml());
    }

    /**
     * @covers \Mail\Mailer::send
     */
    public function testSend()
    {
        // 私有配置文件
        $private_config_file = dirname(__FILE__).'/private.config';

        // 没有私有配置文件，则不需要执行这个单元测试
        if(!file_exists($private_config_file))
        {
            $this->markTestSkipped('This test should not be run.');
        }

        // 解析私有配置文件
        $private_config = json_decode(file_get_contents($private_config_file), true);

        $smtp_host = 'smtp.mxhichina.com';
        $smtp_username = $private_config['smtp_username'];
        $smtp_password = $private_config['smtp_password'];
        $server_config = new \Mail\ServerConfig($smtp_host, $smtp_username, $smtp_password);
        $mailer = new \Mail\Mailer($server_config);

        // sender
        $from_email = $private_config['from_email'];
        $from_name = $private_config['from_name'];
        $sender = new \Mail\Sender($from_email, $from_name);
        $mailer->setSender($sender);

        // recipients
        $recipient_email = $private_config['recipient_email'];
        $recipient_name = $private_config['recipient_name'];
        $recipient = new \Mail\Recipient($recipient_email, $recipient_name);
        $mailer->addRecipient($recipient);

        // cc recipients
        $cc_recipient_email = $private_config['cc_recipient_email'];
        $cc_recipient_name = $private_config['cc_recipient_name'];
        $cc_recipient = new \Mail\Recipient($cc_recipient_email, $cc_recipient_name);
        $mailer->addCcRecipient($cc_recipient);

        // bcc recipients
        $bcc_recipient_email = $private_config['bcc_recipient_email'];
        $bcc_recipient_name = $private_config['bcc_recipient_name'];
        $bcc_recipient = new \Mail\Recipient($bcc_recipient_email, $bcc_recipient_name);
        $mailer->addBccRecipient($bcc_recipient);

        // attachments
        $attachment_file = '/tmp/attachment.txt';
        file_put_contents($attachment_file, 'attachment file');

        $attachment_name = '附件.txt';
        $attachment = new \Mail\Attachment($attachment_file, $attachment_name);
        $mailer->addAttachment($attachment);

        // html
        $mailer->setIsHtml(true);

        // send
        $subject = '测试电邮标题';
        $body = '测试电邮内容';
        $ret = $mailer->send($subject, $body);
        $this->assertTrue($ret);

        if(file_exists($attachment_file))
        {
            unlink($attachment_file);
        }
    }
}