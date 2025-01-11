<?php declare(strict_types=1);
namespace Tests\Csrf\Config;

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-csrf\Csrf\Config\GoogleRecaptchaV3Config
 *
 * @author fdipzone
 */
final class GoogleRecaptchaV3ConfigTest extends TestCase
{
    /**
     * @covers \Csrf\Config\GoogleRecaptchaV3Config::__construct
     */
    public function testConstruct()
    {
        $secret = 'abc123';
        $config = new \Csrf\Config\GoogleRecaptchaV3Config($secret);
        $this->assertEquals('Csrf\Config\GoogleRecaptchaV3Config', get_class($config));
    }

    /**
     * @covers \Csrf\Config\GoogleRecaptchaV3Config::__construct
     */
    public function testConstructException()
    {
        $this->expectException(\Csrf\Exception\ConfigException::class);
        $this->expectExceptionMessage('secret is empty');

        $secret = '';
        new \Csrf\Config\GoogleRecaptchaV3Config($secret);
    }

    /**
     * @covers \Csrf\Config\GoogleRecaptchaV3Config::setTimeout
     * @covers \Csrf\Config\GoogleRecaptchaV3Config::setScoreThreshold
     * @covers \Csrf\Config\GoogleRecaptchaV3Config::secret
     * @covers \Csrf\Config\GoogleRecaptchaV3Config::timeout
     * @covers \Csrf\Config\GoogleRecaptchaV3Config::scoreThreshold
     */
    public function testSetAndGet()
    {
        $secret = 'abc123';
        $timeout = 10;
        $score_threshold = 0.95;
        $config = new \Csrf\Config\GoogleRecaptchaV3Config($secret);

        // 测试默认 timeout and score_threshold
        $this->assertEquals(30, $config->timeout());
        $this->assertEquals(0.5, $config->scoreThreshold());

        // 设置 timeout
        $config->setTimeout($timeout);
        $config->setScoreThreshold($score_threshold);
        $this->assertEquals($secret, $config->secret());
        $this->assertEquals($timeout, $config->timeout());
        $this->assertEquals($score_threshold, $config->scoreThreshold());
    }

    /**
     * @covers \Csrf\Config\GoogleRecaptchaV3Config::setTimeout
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
                    $config = new \Csrf\Config\GoogleRecaptchaV3Config($secret);
                    $config->setTimeout(0);
                },
                'timeout must be between 1 and 300 seconds'
            ),
            array(
                function()
                {
                    $secret = 'abc123';
                    $config = new \Csrf\Config\GoogleRecaptchaV3Config($secret);
                    $config->setTimeout(301);
                },
                'timeout must be between 1 and 300 seconds'
            ),
        );

        return $exception_cases;
    }

    /**
     * @covers \Csrf\Config\GoogleRecaptchaV3Config::setScoreThreshold
     * @dataProvider setScoreThresholdExceptionCases
     */
    public function testSetScoreThresholdException($func, $exception_message)
    {
        $this->expectException(\Csrf\Exception\ConfigException::class);
        $this->expectExceptionMessage($exception_message);
        $func();
    }

    // 测试 setScoreThreshold 异常
    public function setScoreThresholdExceptionCases()
    {
        // 异常情况
        $exception_cases = array(
            array(
                function()
                {
                    $secret = 'abc123';
                    $config = new \Csrf\Config\GoogleRecaptchaV3Config($secret);
                    $config->setScoreThreshold(0.009);
                },
                'score threshold must be between 0.01 and 1'
            ),
            array(
                function()
                {
                    $secret = 'abc123';
                    $config = new \Csrf\Config\GoogleRecaptchaV3Config($secret);
                    $config->setScoreThreshold(1.01);
                },
                'score threshold must be between 0.01 and 1'
            ),
        );

        return $exception_cases;
    }
}