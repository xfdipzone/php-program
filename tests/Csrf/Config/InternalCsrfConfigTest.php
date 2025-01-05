<?php declare(strict_types=1);
namespace Tests\Csrf\Config;

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-csrf\Csrf\Config\InternalCsrfConfig
 *
 * @author fdipzone
 */
final class InternalCsrfConfigTest extends TestCase
{
    /**
     * @covers \Csrf\Config\InternalCsrfConfig::__construct
     */
    public function testConstruct()
    {
        $secret = 'abc123';
        $config = new \Csrf\Config\InternalCsrfConfig($secret);
        $this->assertEquals('Csrf\Config\InternalCsrfConfig', get_class($config));
    }

    /**
     * @covers \Csrf\Config\InternalCsrfConfig::__construct
     */
    public function testConstructException()
    {
        $this->expectException(\Csrf\Exception\ConfigException::class);
        $this->expectExceptionMessage('secret is empty');

        $secret = '';
        new \Csrf\Config\InternalCsrfConfig($secret);
    }

    /**
     * @covers \Csrf\Config\InternalCsrfConfig::setTimeout
     * @covers \Csrf\Config\InternalCsrfConfig::secret
     * @covers \Csrf\Config\InternalCsrfConfig::timeout
     */
    public function testSetAndGet()
    {
        $secret = 'abc123';
        $timeout = 10;
        $config = new \Csrf\Config\InternalCsrfConfig($secret);

        // 测试默认 timeout
        $this->assertEquals(30, $config->timeout());

        // 设置 timeout
        $config->setTimeout($timeout);
        $this->assertEquals($secret, $config->secret());
        $this->assertEquals($timeout, $config->timeout());
    }



    /**
     * @covers \Csrf\Config\InternalCsrfConfig::setTimeout
     * @dataProvider setTimeoutExceptionCases
     */
    public function testSetTimeoutException($func, $exception_message)
    {
        $this->expectException(\Csrf\Exception\ConfigException::class);
        $this->expectExceptionMessage($exception_message);
        $func();
    }

    // 测试 setTimeout 异常
    public function setTimeoutExceptionCases()
    {
        // 异常情况
        $exception_cases = array(
            array(
                function()
                {
                    $secret = 'abc123';
                    $config = new \Csrf\Config\InternalCsrfConfig($secret);
                    $config->setTimeout(0);
                },
                'timeout must be between 1 and 300 seconds'
            ),
            array(
                function()
                {
                    $secret = 'abc123';
                    $config = new \Csrf\Config\InternalCsrfConfig($secret);
                    $config->setTimeout(301);
                },
                'timeout must be between 1 and 300 seconds'
            ),
        );

        return $exception_cases;
    }
}