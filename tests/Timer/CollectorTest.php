<?php declare(strict_types=1);
namespace Tests\Timer;

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-timer\Timer\Collector
 *
 * @author fdipzone
 */
final class CollectorTest extends TestCase
{
    /**
     * @covers \Timer\Collector::__construct
     */
    public function testConstruct()
    {
        $collector = new \Timer\Collector;
        $this->assertEquals(get_class($collector), 'Timer\Collector');
    }

    /**
     * @covers \Timer\Collector::start
     */
    public function testStart()
    {
        $collector = new \Timer\Collector;
        $this->assertEquals(\Timer\Collector::NOT_STARTED, \Tests\Utils\PHPUnitExtension::getVariable($collector, 'state'));
        $collector->start();
        $this->assertEquals(\Timer\Collector::STARTED, \Tests\Utils\PHPUnitExtension::getVariable($collector, 'state'));
    }

    /**
     * @covers \Timer\Collector::start
     */
    public function testStartStateException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('timer collector: the current state cannot be started');

        $collector = new \Timer\Collector;
        $this->assertEquals(\Timer\Collector::NOT_STARTED, \Tests\Utils\PHPUnitExtension::getVariable($collector, 'state'));
        $collector->start();
        $this->assertEquals(\Timer\Collector::STARTED, \Tests\Utils\PHPUnitExtension::getVariable($collector, 'state'));
        $collector->start();
    }

    /**
     * @covers \Timer\Collector::end
     */
    public function testEnd()
    {
        $collector = new \Timer\Collector;
        $this->assertEquals(\Timer\Collector::NOT_STARTED, \Tests\Utils\PHPUnitExtension::getVariable($collector, 'state'));
        $collector->start();
        $this->assertEquals(\Timer\Collector::STARTED, \Tests\Utils\PHPUnitExtension::getVariable($collector, 'state'));
        $collector->end();
        $this->assertEquals(\Timer\Collector::ENDED, \Tests\Utils\PHPUnitExtension::getVariable($collector, 'state'));
    }

    /**
     * @covers \Timer\Collector::end
     */
    public function testEndStateException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('timer collector: the current state cannot be ended');

        $collector = new \Timer\Collector;
        $this->assertEquals(\Timer\Collector::NOT_STARTED, \Tests\Utils\PHPUnitExtension::getVariable($collector, 'state'));
        $collector->end();
    }

    /**
     * @covers \Timer\Collector::savePoint
     */
    public function testSavePoint()
    {
        $collector = new \Timer\Collector;
        $this->assertEquals(\Timer\Collector::NOT_STARTED, \Tests\Utils\PHPUnitExtension::getVariable($collector, 'state'));
        $collector->start();
        $this->assertEquals(\Timer\Collector::STARTED, \Tests\Utils\PHPUnitExtension::getVariable($collector, 'state'));

        $collector->savePoint('event 1');
        $collector->savePoint('event2');
        $this->assertEquals(\Timer\Collector::STARTED, \Tests\Utils\PHPUnitExtension::getVariable($collector, 'state'));

        $collector->end();
        $this->assertEquals(\Timer\Collector::ENDED, \Tests\Utils\PHPUnitExtension::getVariable($collector, 'state'));

        $this->assertSame(4, count($collector->timeline()->events()));
    }

    /**
     * @covers \Timer\Collector::savePoint
     */
    public function testSavePointStateException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('timer collector: the current state cannot be save point');

        $collector = new \Timer\Collector;
        $this->assertEquals(\Timer\Collector::NOT_STARTED, \Tests\Utils\PHPUnitExtension::getVariable($collector, 'state'));
        $collector->savePoint('event');
    }

    /**
     * @covers \Timer\Collector::savePoint
     */
    public function testSavePointContentException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('timer collector: save point content is empty');

        $collector = new \Timer\Collector;
        $this->assertEquals(\Timer\Collector::NOT_STARTED, \Tests\Utils\PHPUnitExtension::getVariable($collector, 'state'));
        $collector->start();
        $this->assertEquals(\Timer\Collector::STARTED, \Tests\Utils\PHPUnitExtension::getVariable($collector, 'state'));
        $collector->savePoint('');
    }

    /**
     * @covers \Timer\Collector::timeline
     */
    public function testTimeline()
    {
        $collector = new \Timer\Collector;
        $collector->start();
        $collector->end();
        $this->assertSame(2, count($collector->timeline()->events()));
    }

    /**
     * @covers \Timer\Collector::timeline
     */
    public function testTimelineStateException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('timer collector: the current state cannot be get timeline');

        $collector = new \Timer\Collector;
        $this->assertEquals(\Timer\Collector::NOT_STARTED, \Tests\Utils\PHPUnitExtension::getVariable($collector, 'state'));
        $collector->start();
        $this->assertEquals(\Timer\Collector::STARTED, \Tests\Utils\PHPUnitExtension::getVariable($collector, 'state'));
        $collector->timeline();
    }

    /**
     * @covers \Timer\Collector::getMilliSecondTimestamp
     */
    public function testGetMilliSecondTimestamp()
    {
        $collector = new \Timer\Collector;
        $millisecond_timestamp = \Tests\Utils\PHPUnitExtension::callMethod($collector, 'getMilliSecondTimestamp', []);
        $this->assertTrue($millisecond_timestamp>0);
    }
}