<?php declare(strict_types=1);
namespace Tests\Csrf;

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-csrf\Csrf\GoogleRecaptchaV2
 *
 * @author fdipzone
 */
final class GoogleRecaptchaV2Test extends TestCase
{
    /**
     * @covers \Csrf\GoogleRecaptchaV2::__construct
     */
    public function testConstruct()
    {
        $secret = 'abc123';
        $config = new \Csrf\Config\GoogleRecaptchaV2Config($secret);
        $google_recaptcha_v2 = new \Csrf\GoogleRecaptchaV2($config);
        $this->assertEquals('Csrf\GoogleRecaptchaV2', get_class($google_recaptcha_v2));
        $this->assertInstanceOf(\Csrf\ICsrf::class, $google_recaptcha_v2);
    }

    /**
     * @covers \Csrf\GoogleRecaptchaV2::__construct
     */
    public function testConstructException()
    {
        $this->expectException(\Csrf\Exception\TokenException::class);
        $this->expectExceptionMessage('config secret is empty');

        $secret = 'abc123';
        $config = new \Csrf\Config\GoogleRecaptchaV2Config($secret);

        // 将 config 的 secret 更新为空
        \Tests\Utils\PHPUnitExtension::setVariable($config, 'secret', '');
        new \Csrf\GoogleRecaptchaV2($config);
    }

    /**
     * @covers \Csrf\GoogleRecaptchaV2::generate
     */
    public function testGenerate()
    {
        $secret = 'abc123';
        $config = new \Csrf\Config\GoogleRecaptchaV2Config($secret);
        $google_recaptcha_v2 = new \Csrf\GoogleRecaptchaV2($config);

        $token = $google_recaptcha_v2->generate('login');
        $this->assertEquals('', $token);
    }

    /**
     * @covers \Csrf\GoogleRecaptchaV2::verify
     */
    public function testVerify()
    {
        $secret = 'abc123';
        $config = new \Csrf\Config\GoogleRecaptchaV2Config($secret);

        $mock_recaptcha_response = new \ReCaptcha\Response(true);

        // mock google recaptcha v2
        $mock_google_recaptcha_v2 = $this->getMockBuilder('\Csrf\GoogleRecaptchaV2')
                                         ->setConstructorArgs([$config])
                                         ->setMethods(['googleRecaptchaVerify'])
                                         ->getMock();
        $mock_google_recaptcha_v2->expects($this->any())
                                 ->method('googleRecaptchaVerify')
                                 ->willReturn($mock_recaptcha_response);

        $action = 'login';
        $remote_ip = '192.168.1.1';
        $token = 'google recaptcha v2 token';
        $response = $mock_google_recaptcha_v2->verify($token, $action, $remote_ip);
        $this->assertTrue($response->success());
        $this->assertSame(0, count($response->errors()));
    }

    /**
     * @covers \Csrf\GoogleRecaptchaV2::verify
     */
    public function testVerifyFail()
    {
        $secret = 'abc123';
        $config = new \Csrf\Config\GoogleRecaptchaV2Config($secret);

        $mock_recaptcha_response = new \ReCaptcha\Response(false, ['error']);

        // mock google recaptcha v2
        $mock_google_recaptcha_v2 = $this->getMockBuilder('\Csrf\GoogleRecaptchaV2')
                                         ->setConstructorArgs([$config])
                                         ->setMethods(['googleRecaptchaVerify'])
                                         ->getMock();
        $mock_google_recaptcha_v2->expects($this->any())
                                 ->method('googleRecaptchaVerify')
                                 ->willReturn($mock_recaptcha_response);

        $action = 'login';
        $remote_ip = '192.168.1.1';
        $token = 'google recaptcha v2 token';
        $response = $mock_google_recaptcha_v2->verify($token, $action, $remote_ip);
        $this->assertFalse($response->success());
        $this->assertSame(1, count($response->errors()));
        $this->assertEquals('error', $response->errors()[0]);
    }

    /**
     * @covers \Csrf\GoogleRecaptchaV2::verify
     */
    public function testVerifyException()
    {
        $this->expectException(\Csrf\Exception\TokenException::class);
        $this->expectExceptionMessage('google recaptcha v2 call fail');

        $secret = 'abc123';
        $config = new \Csrf\Config\GoogleRecaptchaV2Config($secret);

        // mock google recaptcha v2
        $mock_google_recaptcha_v2 = $this->getMockBuilder('\Csrf\GoogleRecaptchaV2')
                                         ->setConstructorArgs([$config])
                                         ->setMethods(['googleRecaptchaVerify'])
                                         ->getMock();
        $mock_google_recaptcha_v2->expects($this->any())
                                 ->method('googleRecaptchaVerify')
                                 ->willThrowException(new \Exception('test exception'));

        $action = 'login';
        $remote_ip = '192.168.1.1';
        $token = 'google recaptcha v2 token';
        $mock_google_recaptcha_v2->verify($token, $action, $remote_ip);
    }
}