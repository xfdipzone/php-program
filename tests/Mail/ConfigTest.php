<?php declare(strict_types=1);
namespace Tests\Mail;

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-mailer\Mail\Config
 *
 * @author fdipzone
 */
final class ConfigTest extends TestCase
{
    /**
     * @covers \Mail\Config::__construct
     */
    public function testConstruct()
    {
        $smtp_host = 'smtp.mxhichina.com';
        $smtp_username = 'fdipzone';
        $smtp_password = '123456abc!@#$';

        $config = new \Mail\Config($smtp_host, $smtp_username, $smtp_password);
        $this->assertEquals('Mail\Config', get_class($config));
    }

    /**
     * @covers \Mail\Config::__construct
     */
    public function testConstructSmtpHostException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('mailer config: smtp host is empty');

        $smtp_host = '';
        $smtp_username = 'fdipzone';
        $smtp_password = '123456abc!@#$';

        new \Mail\Config($smtp_host, $smtp_username, $smtp_password);
    }

    /**
     * @covers \Mail\Config::__construct
     */
    public function testConstructSmtpUsernameException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('mailer config: smtp username is empty');

        $smtp_host = 'smtp.mxhichina.com';
        $smtp_username = '';
        $smtp_password = '123456abc!@#$';

        new \Mail\Config($smtp_host, $smtp_username, $smtp_password);
    }

    /**
     * @covers \Mail\Config::__construct
     */
    public function testConstructSmtpPasswordException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('mailer config: smtp password is empty');

        $smtp_host = 'smtp.mxhichina.com';
        $smtp_username = 'fdipzone';
        $smtp_password = '';

        new \Mail\Config($smtp_host, $smtp_username, $smtp_password);
    }

    /**
     * @covers \Mail\Config
     */
    public function testSetAndGet()
    {
        $smtp_host = 'smtp.mxhichina.com';
        $smtp_port = 465;
        $smtp_secure = 'ssl';
        $smtp_auth = true;
        $smtp_username = 'fdipzone';
        $smtp_password = '123456abc!@#$';
        $smtp_debug = false;

        $config = new \Mail\Config($smtp_host, $smtp_username, $smtp_password);
        $config->setSmtpPort($smtp_port);
        $config->setSmtpSecure($smtp_secure);
        $config->setSmtpAuth($smtp_auth);
        $config->setSmtpDebug($smtp_debug);

        $this->assertEquals($smtp_host, $config->smtpHost());
        $this->assertEquals($smtp_port, $config->smtpPort());
        $this->assertEquals($smtp_secure, $config->smtpSecure());
        $this->assertEquals($smtp_auth, $config->smtpAuth());
        $this->assertEquals($smtp_username, $config->smtpUsername());
        $this->assertEquals($smtp_password, $config->smtpPassword());
        $this->assertEquals($smtp_debug, $config->smtpDebug());
    }

    /**
     * @covers \Mail\Config::setSmtpPort
     */
    public function testSetSmtpPortLowerLimitException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('mailer config: port must be between 0 and 65535');

        $smtp_host = 'smtp.mxhichina.com';
        $smtp_username = 'fdipzone';
        $smtp_password = '123456abc!@#$';

        $config = new \Mail\Config($smtp_host, $smtp_username, $smtp_password);
        $config->setSmtpPort(-1);
    }

    /**
     * @covers \Mail\Config::setSmtpPort
     */
    public function testSetSmtpPortUpperLimitException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('mailer config: port must be between 0 and 65535');

        $smtp_host = 'smtp.mxhichina.com';
        $smtp_username = 'fdipzone';
        $smtp_password = '123456abc!@#$';

        $config = new \Mail\Config($smtp_host, $smtp_username, $smtp_password);
        $config->setSmtpPort(65536);
    }

    /**
     * @covers \Mail\Config::setSmtpSecure
     */
    public function testSetSmtpSecureException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('mailer config: smtp secure is empty');

        $smtp_host = 'smtp.mxhichina.com';
        $smtp_username = 'fdipzone';
        $smtp_password = '123456abc!@#$';

        $config = new \Mail\Config($smtp_host, $smtp_username, $smtp_password);
        $config->setSmtpSecure('');
    }
}