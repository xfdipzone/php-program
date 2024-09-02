<?php declare(strict_types=1);
namespace Tests\Timer;

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-timer\Timer\Event
 *
 * @author fdipzone
 */
final class EventTest extends TestCase
{
    /**
     * @covers \Timer\Event::__construct
     */
    public function testConstruct()
    {
        $millisecond_timestamp = time()*1000+mt_rand(100,999);
        $content = 'event content';
        $event = new \Timer\Event($millisecond_timestamp, $content);
        $this->assertEquals('Timer\Event', get_class($event));
    }

    /**
     * @covers \Timer\Event::__construct
     */
    public function testConstructTimestampException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('timer event: millisecond timestamp invalid');
        $millisecond_timestamp = 0;
        $content = 'event content';
        new \Timer\Event($millisecond_timestamp, $content);
    }

    /**
     * @covers \Timer\Event::__construct
     */
    public function testConstructContentException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('timer event: content is empty');
        $millisecond_timestamp = time()*1000+mt_rand(100,999);
        $content = '';
        new \Timer\Event($millisecond_timestamp, $content);
    }

    /**
     * @covers \Timer\Event::millisecondTimestamp
     */
    public function testMillisecondTimestamp()
    {
        $millisecond_timestamp = time()*1000+mt_rand(100,999);
        $content = 'event content';
        $event = new \Timer\Event($millisecond_timestamp, $content);
        $this->assertEquals($millisecond_timestamp, $event->millisecondTimestamp());
    }

    /**
     * @covers \Timer\Event::content
     */
    public function testContent()
    {
        $millisecond_timestamp = time()*1000+mt_rand(100,999);
        $content = 'event content';
        $event = new \Timer\Event($millisecond_timestamp, $content);
        $this->assertEquals($content, $event->content());
    }
}