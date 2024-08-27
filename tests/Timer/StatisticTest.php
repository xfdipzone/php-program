<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-timer\Timer\Statistic
 *
 * @author fdipzone
 */
final class StatisticTest extends TestCase
{
    /**
     * @covers \Timer\Statistic::__construct
     */
    public function testConstruct()
    {
        $now = time();
        $event_start = new \Timer\Event($now*1000+100, 'start');
        $event_end = new \Timer\Event($now*1000+200, 'end');

        $timeline = new \Timer\Timeline;
        $timeline->push($event_start);
        $timeline->push($event_end);

        $statistic = new \Timer\Statistic($timeline);
        $this->assertEquals(get_class($statistic), 'Timer\Statistic');
    }

    /**
     * @covers \Timer\Statistic::__construct
     */
    public function testConstructException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('timer statistic: timeline invalid');

        $now = time();
        $event = new \Timer\Event($now*1000+100, 'start');

        $timeline = new \Timer\Timeline;
        $timeline->push($event);

        new \Timer\Statistic($timeline);
    }

    /**
     * @covers \Timer\Statistic::totalTime
     */
    public function testTotalTime()
    {
        $now = time();
        $event_start = new \Timer\Event($now*1000+100, 'start');
        $event_end = new \Timer\Event($now*1000+200, 'end');

        $timeline = new \Timer\Timeline;
        $timeline->push($event_start);
        $timeline->push($event_end);

        $statistic = new \Timer\Statistic($timeline);
        $this->assertEquals(100, $statistic->totalTime());
    }

    /**
     * @covers \Timer\Statistic::totalTime
     */
    public function testTotalTimeMoreEvents()
    {
        $now = time();
        $event_start = new \Timer\Event($now*1000+100, 'start');
        $event1 = new \Timer\Event($now*1000+120, 'event1');
        $event2 = new \Timer\Event($now*1000+130, 'event2');
        $event3 = new \Timer\Event($now*1000+160, 'event3');
        $event_end = new \Timer\Event($now*1000+200, 'end');

        $timeline = new \Timer\Timeline;
        $timeline->push($event_start);
        $timeline->push($event1);
        $timeline->push($event2);
        $timeline->push($event3);
        $timeline->push($event_end);

        $statistic = new \Timer\Statistic($timeline);
        $this->assertEquals(100, $statistic->totalTime());
    }

    /**
     * @covers \Timer\Statistic::detailTime
     */
    public function testDetailTime()
    {
        $now = time();
        $event_start = new \Timer\Event($now*1000+100, 'start');
        $event_end = new \Timer\Event($now*1000+200, 'end');

        $timeline = new \Timer\Timeline;
        $timeline->push($event_start);
        $timeline->push($event_end);

        $statistic = new \Timer\Statistic($timeline);
        $detail_time = $statistic->detailTime();
        $this->assertSame(2, count($detail_time));
        $this->assertSame(0, $detail_time[0]['execution_time']);
        $this->assertSame(0, $detail_time[0]['flow_execution_time']);
        $this->assertSame(100, $detail_time[1]['execution_time']);
        $this->assertSame(100, $detail_time[1]['flow_execution_time']);
    }

    /**
     * @covers \Timer\Statistic::detailTime
     */
    public function testDetailTimeMoreEvents()
    {
        $now = time();
        $event_start = new \Timer\Event($now*1000+100, 'start');
        $event1 = new \Timer\Event($now*1000+120, 'event1');
        $event2 = new \Timer\Event($now*1000+130, 'event2');
        $event3 = new \Timer\Event($now*1000+160, 'event3');
        $event_end = new \Timer\Event($now*1000+200, 'end');

        $timeline = new \Timer\Timeline;
        $timeline->push($event_start);
        $timeline->push($event1);
        $timeline->push($event2);
        $timeline->push($event3);
        $timeline->push($event_end);

        $statistic = new \Timer\Statistic($timeline);
        $detail_time = $statistic->detailTime();
        $this->assertSame(5, count($detail_time));
        $this->assertSame(date('Y-m-d H:i:s', $now).'.100', $detail_time[0]['time']);
        $this->assertSame('start', $detail_time[0]['content']);
        $this->assertSame(0, $detail_time[0]['execution_time']);
        $this->assertSame(0, $detail_time[0]['flow_execution_time']);
        $this->assertSame(date('Y-m-d H:i:s', $now).'.120', $detail_time[1]['time']);
        $this->assertSame('event1', $detail_time[1]['content']);
        $this->assertSame(20, $detail_time[1]['execution_time']);
        $this->assertSame(20, $detail_time[1]['flow_execution_time']);
        $this->assertSame(date('Y-m-d H:i:s', $now).'.130', $detail_time[2]['time']);
        $this->assertSame('event2', $detail_time[2]['content']);
        $this->assertSame(10, $detail_time[2]['execution_time']);
        $this->assertSame(30, $detail_time[2]['flow_execution_time']);
        $this->assertSame(date('Y-m-d H:i:s', $now).'.160', $detail_time[3]['time']);
        $this->assertSame('event3', $detail_time[3]['content']);
        $this->assertSame(30, $detail_time[3]['execution_time']);
        $this->assertSame(60, $detail_time[3]['flow_execution_time']);
        $this->assertSame(date('Y-m-d H:i:s', $now).'.200', $detail_time[4]['time']);
        $this->assertSame('end', $detail_time[4]['content']);
        $this->assertSame(40, $detail_time[4]['execution_time']);
        $this->assertSame(100, $detail_time[4]['flow_execution_time']);
    }
}