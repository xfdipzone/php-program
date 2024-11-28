<?php declare(strict_types=1);
namespace Tests\Metric;

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-metric\Metric\Counter
 *
 * @author fdipzone
 */
final class CounterTest extends TestCase
{
    /**
     * @covers \Metric\Counter::__construct
     */
    public function testConstruct()
    {
        $max_times = 3;
        $counter_metric = new \Metric\Counter($max_times);
        $this->assertEquals('Metric\Counter', get_class($counter_metric));
        $this->assertInstanceOf(\Metric\IMetric::class, $counter_metric);
        $this->assertInstanceOf(\Metric\IMetricCallback::class, $counter_metric);
    }

    /**
     * @covers \Metric\Counter::__construct
     */
    public function testConstructException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('max times must be greater than 0');

        $max_times = 0;
        new \Metric\Counter($max_times);
    }

    /**
     * @covers \Metric\Counter::next
     * @covers \Metric\Counter::setCallback
     */
    public function testNext()
    {
        $callback_result = '';
        $callback = function() use (&$callback_result)
        {
            $callback_result = 'ok';
        };

        $max_times = 3;
        $counter_metric = new \Metric\Counter($max_times);
        $counter_metric->setCallback($callback);

        $ret = $counter_metric->next();
        $this->assertTrue($ret);

        $ret = $counter_metric->next();
        $this->assertTrue($ret);

        $ret = $counter_metric->next();
        $this->assertFalse($ret);
        $this->assertEquals('ok', $callback_result);
    }

    /**
     * @covers \Metric\Counter::setCallback
     */
    public function testSetCallbackException()
    {
        $this->expectException(\TypeError::class);

        $max_times = 3;
        $counter_metric = new \Metric\Counter($max_times);
        $counter_metric->setCallback('abc');
    }
}