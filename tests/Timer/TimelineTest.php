<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-timer\Timer\Timeline
 *
 * @author fdipzone
 */
final class TimelineTest extends TestCase
{
    /**
     * @covers \Timer\Timeline::push
     */
    public function testPush()
    {
        $millisecond_timestamp = time()*1000+100;
        $content = 'event content1';
        $event1 = new \Timer\Event($millisecond_timestamp, $content);

        $millisecond_timestamp = time()*1000+200;
        $content = 'event content2';
        $event2 = new \Timer\Event($millisecond_timestamp, $content);

        $timeline = new \Timer\Timeline;
        $timeline->push($event1);
        $timeline->push($event2);

        $this->assertSame(2, count($timeline->events()));
    }

    /**
     * @covers \Timer\Timeline::events
     */
    public function testEvents()
    {
        $millisecond_timestamp1 = time()*1000+100;
        $content1 = 'event content1';
        $event1 = new \Timer\Event($millisecond_timestamp1, $content1);

        $millisecond_timestamp2 = time()*1000+200;
        $content2 = 'event content2';
        $event2 = new \Timer\Event($millisecond_timestamp2, $content2);

        $timeline = new \Timer\Timeline;
        $timeline->push($event1);
        $timeline->push($event2);

        $events = $timeline->events();
        $this->assertEquals($millisecond_timestamp1, $events[0]->millisecondTimestamp());
        $this->assertEquals($content1, $events[0]->content());
        $this->assertEquals($millisecond_timestamp2, $events[1]->millisecondTimestamp());
        $this->assertEquals($content2, $events[1]->content());
    }
}