<?php declare(strict_types=1);
namespace Tests\Metric;

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-metric\Metric\Timer
 *
 * @author fdipzone
 */
final class TimerTest extends TestCase
{
    /**
     * @covers \Metric\Timer::__construct
     */
    public function testConstruct()
    {
        $max_seconds = 3;
        $timer_metric = new \Metric\Timer($max_seconds);
        $this->assertEquals('Metric\Timer', get_class($timer_metric));
        $this->assertInstanceOf(\Metric\IMetric::class, $timer_metric);
        $this->assertInstanceOf(\Metric\IMetricCallback::class, $timer_metric);
    }

    /**
     * @covers \Metric\Timer::__construct
     */
    public function testConstructException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('max seconds must be greater than 0');

        $max_seconds = 0;
        new \Metric\Timer($max_seconds);
    }

    /**
     * @covers \Metric\Timer::next
     * @covers \Metric\Timer::setCallback
     */
    public function testNext()
    {
        $callback_result = '';
        $callback = function() use (&$callback_result)
        {
            $callback_result = 'ok';
        };

        $max_seconds = 1;
        $timer_metric = new \Metric\Timer($max_seconds);
        $timer_metric->setCallback($callback);

        $ret = $timer_metric->next();
        $this->assertTrue($ret);
        usleep(520*1000);

        $ret = $timer_metric->next();
        $this->assertTrue($ret);
        usleep(520*1000);

        $ret = $timer_metric->next();
        $this->assertFalse($ret);
        $this->assertEquals('ok', $callback_result);
    }

    /**
     * @covers \Metric\Timer::setCallback
     */
    public function testSetCallbackException()
    {
        $this->expectException(\TypeError::class);

        $max_seconds = 3;
        $timer_metric = new \Metric\Timer($max_seconds);
        $timer_metric->setCallback('abc');
    }
}