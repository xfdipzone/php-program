<?php declare(strict_types=1);
namespace Tests\Backoff;

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-backoff\Backoff\Request
 *
 * @author fdipzone
 */
final class RequestTest extends TestCase
{
    /**
     * @covers \Backoff\Request::__construct
     */
    public function testConstruct()
    {
        $retry_times = 3;
        $request = new \Backoff\Request($retry_times);
        $this->assertEquals('Backoff\Request', get_class($request));
    }

    /**
     * @covers \Backoff\Request::__construct
     */
    public function testConstructException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('retry times cannot be less than 0');

        $retry_times = -1;
        new \Backoff\Request($retry_times);
    }

    /**
     * @covers \Backoff\Request::retryTimes
     */
    public function testRetryTimes()
    {
        $retry_times = 3;
        $request = new \Backoff\Request($retry_times);
        $this->assertSame($retry_times, $request->retryTimes());
    }
}