<?php declare(strict_types=1);
namespace Tests\Csrf;

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-csrf\Csrf\GoogleRecaptchaV3
 *
 * @author fdipzone
 */
final class GoogleRecaptchaV3Test extends TestCase
{
    /**
     * @covers \Csrf\GoogleRecaptchaV3::__construct
     */
    public function testConstruct()
    {
        $secret = 'abc123';
        $config = new \Csrf\Config\GoogleRecaptchaV3Config($secret);
        $google_recaptcha_v3 = new \Csrf\GoogleRecaptchaV3($config);
        $this->assertEquals('Csrf\GoogleRecaptchaV3', get_class($google_recaptcha_v3));
        $this->assertInstanceOf(\Csrf\ICsrf::class, $google_recaptcha_v3);
    }

    /**
     * @covers \Csrf\GoogleRecaptchaV3::__construct
     */
    public function testConstructException()
    {
        $this->expectException(\Csrf\Exception\TokenException::class);
        $this->expectExceptionMessage('config secret is empty');

        $secret = 'abc123';
        $config = new \Csrf\Config\GoogleRecaptchaV3Config($secret);

        // 将 config 的 secret 更新为空
        \Tests\Utils\PHPUnitExtension::setVariable($config, 'secret', '');
        new \Csrf\GoogleRecaptchaV3($config);
    }

    /**
     * @covers \Csrf\GoogleRecaptchaV3::generate
     */
    public function testGenerate()
    {
        $secret = 'abc123';
        $config = new \Csrf\Config\GoogleRecaptchaV3Config($secret);
        $google_recaptcha_v3 = new \Csrf\GoogleRecaptchaV3($config);

        $token = $google_recaptcha_v3->generate('login');
        $this->assertEquals('', $token);
    }

    /**
     * @covers \Csrf\GoogleRecaptchaV3::verify
     */
    public function testVerify()
    {
        $secret = 'abc123';
        $config = new \Csrf\Config\GoogleRecaptchaV3Config($secret);

        $mock_recaptcha_response = new \ReCaptcha\Response(true);

        // mock google recaptcha v3
        $mock_google_recaptcha_v3 = $this->getMockBuilder('\Csrf\GoogleRecaptchaV3')
                                         ->setConstructorArgs([$config])
                                         ->setMethods(['googleRecaptchaVerify'])
                                         ->getMock();
        $mock_google_recaptcha_v3->expects($this->any())
                                 ->method('googleRecaptchaVerify')
                                 ->willReturn($mock_recaptcha_response);

        $action = 'login';
        $remote_ip = '192.168.1.1';
        $token = 'google recaptcha v3 token';
        $response = $mock_google_recaptcha_v3->verify($token, $action, $remote_ip);
        $this->assertTrue($response->success());
        $this->assertSame(0, count($response->errors()));
    }

    /**
     * @covers \Csrf\GoogleRecaptchaV3::verify
     */
    public function testVerifyFail()
    {
        $secret = 'abc123';
        $config = new \Csrf\Config\GoogleRecaptchaV3Config($secret);

        $mock_recaptcha_response = new \ReCaptcha\Response(false, ['error']);

        // mock google recaptcha v3
        $mock_google_recaptcha_v3 = $this->getMockBuilder('\Csrf\GoogleRecaptchaV3')
                                         ->setConstructorArgs([$config])
                                         ->setMethods(['googleRecaptchaVerify'])
                                         ->getMock();
        $mock_google_recaptcha_v3->expects($this->any())
                                 ->method('googleRecaptchaVerify')
                                 ->willReturn($mock_recaptcha_response);

        $action = 'login';
        $remote_ip = '192.168.1.1';
        $token = 'google recaptcha v3 token';
        $response = $mock_google_recaptcha_v3->verify($token, $action, $remote_ip);
        $this->assertFalse($response->success());
        $this->assertSame(1, count($response->errors()));
        $this->assertEquals('error', $response->errors()[0]);
    }

    /**
     * @covers \Csrf\GoogleRecaptchaV3::verify
     */
    public function testVerifyException()
    {
        $this->expectException(\Csrf\Exception\TokenException::class);
        $this->expectExceptionMessage('google recaptcha v3 call fail');

        $secret = 'abc123';
        $config = new \Csrf\Config\GoogleRecaptchaV3Config($secret);

        // mock google recaptcha v3
        $mock_google_recaptcha_v3 = $this->getMockBuilder('\Csrf\GoogleRecaptchaV3')
                                         ->setConstructorArgs([$config])
                                         ->setMethods(['googleRecaptchaVerify'])
                                         ->getMock();
        $mock_google_recaptcha_v3->expects($this->any())
                                 ->method('googleRecaptchaVerify')
                                 ->willThrowException(new \Exception('test exception'));

        $action = 'login';
        $remote_ip = '192.168.1.1';
        $token = 'google recaptcha v3 token';
        $mock_google_recaptcha_v3->verify($token, $action, $remote_ip);
    }

    /**
     * @covers \Csrf\GoogleRecaptchaV3::googleRecaptchaVerify
     */
    public function testGoogleRecaptchaVerify()
    {
        $secret = 'abc123';
        $config = new \Csrf\Config\GoogleRecaptchaV3Config($secret);
        $google_recaptcha_v3 = new \Csrf\GoogleRecaptchaV3($config);

        $action = 'login';
        $remote_ip = '192.168.1.1';
        $token = '';
        $recaptcha_response = \Tests\Utils\PHPUnitExtension::callMethod($google_recaptcha_v3, 'googleRecaptchaVerify', [$token, $action, $remote_ip]);
        $this->assertFalse($recaptcha_response->isSuccess());
        $this->assertSame(1, count($recaptcha_response->getErrorCodes()));
        $this->assertEquals(\ReCaptcha\Recaptcha::E_MISSING_INPUT_RESPONSE, $recaptcha_response->getErrorCodes()[0]);
    }
}