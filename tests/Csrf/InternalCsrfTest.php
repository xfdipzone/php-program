<?php declare(strict_types=1);
namespace Tests\Csrf;

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-csrf\Csrf\InternalCsrf
 *
 * @author fdipzone
 */
final class InternalCsrfTest extends TestCase
{
    /**
     * @covers \Csrf\InternalCsrf::__construct
     */
    public function testConstruct()
    {
        $secret = 'abc123';
        $config = new \Csrf\Config\InternalCsrfConfig($secret);
        $internal_csrf = new \Csrf\InternalCsrf($config);
        $this->assertEquals('Csrf\InternalCsrf', get_class($internal_csrf));
        $this->assertInstanceOf(\Csrf\ICsrf::class, $internal_csrf);
    }

    /**
     * @covers \Csrf\InternalCsrf::__construct
     */
    public function testConstructException()
    {
        $this->expectException(\Csrf\Exception\TokenException::class);
        $this->expectExceptionMessage('config secret is empty');

        $secret = 'abc123';
        $config = new \Csrf\Config\InternalCsrfConfig($secret);

        // 将 config 的 secret 更新为空
        \Tests\Utils\PHPUnitExtension::setVariable($config, 'secret', '');
        new \Csrf\InternalCsrf($config);
    }

    /**
     * @covers \Csrf\InternalCsrf::checkExpire
     */
    public function testCheckExpire()
    {
        $secret = 'abc123';
        $config = new \Csrf\Config\InternalCsrfConfig($secret);
        $internal_csrf = new \Csrf\InternalCsrf($config);

        $token_time = time()-29;
        $timeout = 30;
        $ret = \Tests\Utils\PHPUnitExtension::callMethod($internal_csrf, 'checkExpire', [$token_time, $timeout]);
        $this->assertTrue($ret);

        $token_time = time()-31;
        $timeout = 30;
        $ret = \Tests\Utils\PHPUnitExtension::callMethod($internal_csrf, 'checkExpire', [$token_time, $timeout]);
        $this->assertFalse($ret);
    }

    /**
     * @covers \Csrf\InternalCsrf::response
     */
    public function testResponse()
    {
        $secret = 'abc123';
        $config = new \Csrf\Config\InternalCsrfConfig($secret);
        $internal_csrf = new \Csrf\InternalCsrf($config);

        $response = \Tests\Utils\PHPUnitExtension::callMethod($internal_csrf, 'response', [true, []]);
        $this->assertTrue($response->success());
        $this->assertSame(0, count($response->errors()));

        $response = \Tests\Utils\PHPUnitExtension::callMethod($internal_csrf, 'response', [false, ['error1', 'error2', 'error3']]);
        $this->assertFalse($response->success());
        $this->assertSame(3, count($response->errors()));
        $this->assertEquals('error1', $response->errors()[0]);
        $this->assertEquals('error2', $response->errors()[1]);
        $this->assertEquals('error3', $response->errors()[2]);
    }
}