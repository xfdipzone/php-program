<?php declare(strict_types=1);
namespace Tests\Mail;

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-mailer\Mail\ServerConfig
 *
 * @author fdipzone
 */
final class ServerConfigTest extends TestCase
{
    /**
     * @covers \Mail\ServerConfig::__construct
     */
    public function testConstruct()
    {
        $smtp_host = 'smtp.mxhichina.com';
        $smtp_username = 'fdipzone';
        $smtp_password = '123456abc!@#$';

        $server_config = new \Mail\ServerConfig($smtp_host, $smtp_username, $smtp_password);
        $this->assertEquals('Mail\ServerConfig', get_class($server_config));
    }

    /**
     * @covers \Mail\ServerConfig::__construct
     */
    public function testConstructSmtpHostException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('mailer config: smtp host is empty');

        $smtp_host = '';
        $smtp_username = 'fdipzone';
        $smtp_password = '123456abc!@#$';

        new \Mail\ServerConfig($smtp_host, $smtp_username, $smtp_password);
    }

    /**
     * @covers \Mail\ServerConfig::__construct
     */
    public function testConstructSmtpUsernameException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('mailer config: smtp username is empty');

        $smtp_host = 'smtp.mxhichina.com';
        $smtp_username = '';
        $smtp_password = '123456abc!@#$';

        new \Mail\ServerConfig($smtp_host, $smtp_username, $smtp_password);
    }

    /**
     * @covers \Mail\ServerConfig::__construct
     */
    public function testConstructSmtpPasswordException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('mailer config: smtp password is empty');

        $smtp_host = 'smtp.mxhichina.com';
        $smtp_username = 'fdipzone';
        $smtp_password = '';

        new \Mail\ServerConfig($smtp_host, $smtp_username, $smtp_password);
    }

    /**
     * @covers \Mail\ServerConfig
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

        $server_config = new \Mail\ServerConfig($smtp_host, $smtp_username, $smtp_password);
        $server_config->setSmtpPort($smtp_port);
        $server_config->setSmtpSecure($smtp_secure);
        $server_config->setSmtpAuth($smtp_auth);
        $server_config->setSmtpDebug($smtp_debug);

        $this->assertEquals($smtp_host, $server_config->smtpHost());
        $this->assertEquals($smtp_port, $server_config->smtpPort());
        $this->assertEquals($smtp_secure, $server_config->smtpSecure());
        $this->assertEquals($smtp_auth, $server_config->smtpAuth());
        $this->assertEquals($smtp_username, $server_config->smtpUsername());
        $this->assertEquals($smtp_password, $server_config->smtpPassword());
        $this->assertEquals($smtp_debug, $server_config->smtpDebug());
    }

    /**
     * @covers \Mail\ServerConfig::setSmtpPort
     */
    public function testSetSmtpPortLowerLimitException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('mailer config: port must be between 0 and 65535');

        $smtp_host = 'smtp.mxhichina.com';
        $smtp_username = 'fdipzone';
        $smtp_password = '123456abc!@#$';

        $server_config = new \Mail\ServerConfig($smtp_host, $smtp_username, $smtp_password);
        $server_config->setSmtpPort(-1);
    }

    /**
     * @covers \Mail\ServerConfig::setSmtpPort
     */
    public function testSetSmtpPortUpperLimitException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('mailer config: port must be between 0 and 65535');

        $smtp_host = 'smtp.mxhichina.com';
        $smtp_username = 'fdipzone';
        $smtp_password = '123456abc!@#$';

        $server_config = new \Mail\ServerConfig($smtp_host, $smtp_username, $smtp_password);
        $server_config->setSmtpPort(65536);
    }

    /**
     * @covers \Mail\ServerConfig::setSmtpSecure
     */
    public function testSetSmtpSecureException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('mailer config: smtp secure is empty');

        $smtp_host = 'smtp.mxhichina.com';
        $smtp_username = 'fdipzone';
        $smtp_password = '123456abc!@#$';

        $server_config = new \Mail\ServerConfig($smtp_host, $smtp_username, $smtp_password);
        $server_config->setSmtpSecure('');
    }
}