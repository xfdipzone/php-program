<?php declare(strict_types=1);
namespace Tests\Backoff;

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-backoff\Backoff\Response
 *
 * @author fdipzone
 */
final class ResponseTest extends TestCase
{
    /**
     * @covers \Backoff\Response::__construct
     */
    public function testConstruct()
    {
        $retry = true;
        $retry_interval = 10;
        $response = new \Backoff\Response($retry, $retry_interval);
        $this->assertEquals('Backoff\Response', get_class($response));
    }

    /**
     * @covers \Backoff\Response::__construct
     */
    public function testConstructException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('retry interval cannot be less than 0');

        $retry = true;
        $retry_interval = -1;
        new \Backoff\Response($retry, $retry_interval);
    }

    /**
     * @covers \Backoff\Response::retry
     * @covers \Backoff\Response::retryInterval
     */
    public function testRetryAndRetryInterval()
    {
        $retry = true;
        $retry_interval = 10;
        $response = new \Backoff\Response($retry, $retry_interval);
        $this->assertSame($retry, $response->retry());
        $this->assertSame($retry_interval, $response->retryInterval());
    }
}