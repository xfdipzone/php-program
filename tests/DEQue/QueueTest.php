<?php declare(strict_types=1);
namespace Tests\DEQue;

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-deque\DEQue
 *
 * @author fdipzone
 */
final class QueueTest extends TestCase
{
    public function testQueue()
    {
        // 入队出队不限制
        $de_queue = \DEQue\Queue::getInstance('double_queue', \DEQue\Type::UNRESTRICTED, 10);
        $de_queue->pushFront(new \DEQue\Item('a'));
        $de_queue->pushRear(new \DEQue\Item('b'));
        $de_queue->pushFront(new \DEQue\Item('c'));
        $de_queue->pushRear(new \DEQue\Item('d'));
        $de_queue->pushFront(new \DEQue\Item('e'));

        $resp = $de_queue->popFront();
        $this->assertEquals($resp->item()->data(), 'e');

        $resp = $de_queue->popFront();
        $this->assertEquals($resp->item()->data(), 'c');

        $resp = $de_queue->popFront();
        $this->assertEquals($resp->item()->data(), 'a');

        $resp = $de_queue->popRear();
        $this->assertEquals($resp->item()->data(), 'd');

        $resp = $de_queue->popRear();
        $this->assertEquals($resp->item()->data(), 'b');

        // 队列已满
        $de_queue = \DEQue\Queue::getInstance('double_queue', \DEQue\Type::UNRESTRICTED, 2);
        $resp = $de_queue->pushFront(new \DEQue\Item('a'));
        $this->assertEquals($resp->error(), 0);

        $resp = $de_queue->pushFront(new \DEQue\Item('b'));
        $this->assertEquals($resp->error(), 0);

        $resp = $de_queue->pushFront(new \DEQue\Item('c'));
        $this->assertEquals($resp->error(), \DEQue\ErrCode::FULL);

        $resp = $de_queue->pushRear(new \DEQue\Item('d'));
        $this->assertEquals($resp->error(), \DEQue\ErrCode::FULL);

        $clear = $de_queue->clear();
        $this->assertEquals($clear, true);

        // 队列为空
        $de_queue = \DEQue\Queue::getInstance('double_queue', \DEQue\Type::UNRESTRICTED, 2);
        $resp = $de_queue->popFront();
        $this->assertEquals($resp->error(), \DEQue\ErrCode::EMPTY);

        $resp = $de_queue->popRear();
        $this->assertEquals($resp->error(), \DEQue\ErrCode::EMPTY);

        // 头部入队限制
        $de_queue = \DEQue\Queue::getInstance('double_queue', \DEQue\Type::FRONT_ONLY_OUT, 10);
        $resp = $de_queue->pushFront(new \DEQue\Item('a'));
        $this->assertEquals($resp->error(), \DEQue\ErrCode::FRONT_ENQUEUE_RESTRICTED);

        // 头部出队限制
        $de_queue = \DEQue\Queue::getInstance('double_queue', \DEQue\Type::FRONT_ONLY_IN, 10);
        $de_queue->pushFront(new \DEQue\Item('a'));
        $resp = $de_queue->popFront();
        $this->assertEquals($resp->error(), \DEQue\ErrCode::FRONT_DEQUEUE_RESTRICTED);
        $resp = $de_queue->popRear();
        $this->assertEquals($resp->error(), 0);
        $this->assertEquals($resp->item()->data(), 'a');

        // 尾部入队限制
        $de_queue = \DEQue\Queue::getInstance('double_queue', \DEQue\Type::REAR_ONLY_OUT, 10);
        $resp = $de_queue->pushRear(new \DEQue\Item('a'));
        $this->assertEquals($resp->error(), \DEQue\ErrCode::REAR_ENQUEUE_RESTRICTED);

        // 尾部出队限制
        $de_queue = \DEQue\Queue::getInstance('double_queue', \DEQue\Type::REAR_ONLY_IN, 10);
        $de_queue->pushRear(new \DEQue\Item('a'));
        $resp = $de_queue->popRear();
        $this->assertEquals($resp->error(), \DEQue\ErrCode::REAR_DEQUEUE_RESTRICTED);
        $resp = $de_queue->popFront();
        $this->assertEquals($resp->error(), 0);
        $this->assertEquals($resp->item()->data(), 'a');

        // 入队与出队方向一致限制
        $de_queue = \DEQue\Queue::getInstance('double_queue', \DEQue\Type::SAME_ENDPOINT, 10);
        $de_queue->pushFront(new \DEQue\Item('a'));
        $resp = $de_queue->popRear();
        $this->assertEquals($resp->error(), \DEQue\ErrCode::DIFFERENT_ENDPOINT);
        $resp = $de_queue->popFront();
        $this->assertEquals($resp->error(), 0);
        $this->assertEquals($resp->item()->data(), 'a');

        $de_queue->pushRear(new \DEQue\Item('b'));
        $resp = $de_queue->popFront();
        $this->assertEquals($resp->error(), \DEQue\ErrCode::DIFFERENT_ENDPOINT);

        $resp = $de_queue->popRear();
        $this->assertEquals($resp->error(), 0);
        $this->assertEquals($resp->item()->data(), 'b');
    }

    /**
     * @covers \DEQue\Queue::getInstance
     */
    public function testGetInstanceQueueNameEmptyException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('queue name is empty');
        \DEQue\Queue::getInstance('', \DEQue\Type::UNRESTRICTED);
    }

    /**
     * @covers \DEQue\Queue::getInstance
     */
    public function testGetInstanceQueueTypeException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('queue type invalid');
        \DEQue\Queue::getInstance('double_queue', 0);
    }

    /**
     * @covers \DEQue\Queue::getInstance
     */
    public function testGetInstanceQueueMaxLengthException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('queue max length invalid');
        \DEQue\Queue::getInstance('double_queue', \DEQue\Type::UNRESTRICTED, -1);
    }

    /**
     * @covers \DEQue\Queue::pushFront
     */
    public function testPushFrontLockTimeout()
    {
        // mock mutex lock
        $mock_lock = $this->getMockBuilder('\DEQue\MutexLock')
                          ->setConstructorArgs(['double_queue:1:10'])
                          ->setMethods(['lock'])
                          ->getMock();
        $mock_lock->expects($this->any())
                  ->method('lock')
                  ->willReturn(false);

        $de_queue = \DEQue\Queue::getInstance('double_queue', \DEQue\Type::UNRESTRICTED, 10);

        // 修改 mutex 属性
        \Tests\Utils\PHPUnitExtension::setVariable($de_queue, 'mutex', $mock_lock);

        $resp = $de_queue->pushFront(new \DEQue\Item('a'));
        $this->assertEquals(\DEQue\ErrCode::TRYLOCK_TIMEOUT, $resp->error());
        $this->assertEquals(\DEQue\ErrCode::msg(\DEQue\ErrCode::TRYLOCK_TIMEOUT), $resp->errMsg());
    }

    /**
     * @covers \DEQue\Queue::popFront
     */
    public function testPopFrontLockTimeout()
    {
        // mock mutex lock
        $mock_lock = $this->getMockBuilder('\DEQue\MutexLock')
                          ->setConstructorArgs(['double_queue:1:10'])
                          ->setMethods(['lock'])
                          ->getMock();
        $mock_lock->expects($this->any())
                  ->method('lock')
                  ->willReturn(false);

        $de_queue = \DEQue\Queue::getInstance('double_queue', \DEQue\Type::UNRESTRICTED, 10);

        // 修改 mutex 属性
        \Tests\Utils\PHPUnitExtension::setVariable($de_queue, 'mutex', $mock_lock);

        $resp = $de_queue->popFront();
        $this->assertEquals(\DEQue\ErrCode::TRYLOCK_TIMEOUT, $resp->error());
        $this->assertEquals(\DEQue\ErrCode::msg(\DEQue\ErrCode::TRYLOCK_TIMEOUT), $resp->errMsg());
    }

    /**
     * @covers \DEQue\Queue::pushRear
     */
    public function testPushRearLockTimeout()
    {
        // mock mutex lock
        $mock_lock = $this->getMockBuilder('\DEQue\MutexLock')
                          ->setConstructorArgs(['double_queue:1:10'])
                          ->setMethods(['lock'])
                          ->getMock();
        $mock_lock->expects($this->any())
                  ->method('lock')
                  ->willReturn(false);

        $de_queue = \DEQue\Queue::getInstance('double_queue', \DEQue\Type::UNRESTRICTED, 10);

        // 修改 mutex 属性
        \Tests\Utils\PHPUnitExtension::setVariable($de_queue, 'mutex', $mock_lock);

        $resp = $de_queue->pushRear(new \DEQue\Item('a'));
        $this->assertEquals(\DEQue\ErrCode::TRYLOCK_TIMEOUT, $resp->error());
        $this->assertEquals(\DEQue\ErrCode::msg(\DEQue\ErrCode::TRYLOCK_TIMEOUT), $resp->errMsg());
    }

    /**
     * @covers \DEQue\Queue::popRear
     */
    public function testPopRearLockTimeout()
    {
        // mock mutex lock
        $mock_lock = $this->getMockBuilder('\DEQue\MutexLock')
                          ->setConstructorArgs(['double_queue:1:10'])
                          ->setMethods(['lock'])
                          ->getMock();
        $mock_lock->expects($this->any())
                  ->method('lock')
                  ->willReturn(false);

        $de_queue = \DEQue\Queue::getInstance('double_queue', \DEQue\Type::UNRESTRICTED, 10);

        // 修改 mutex 属性
        \Tests\Utils\PHPUnitExtension::setVariable($de_queue, 'mutex', $mock_lock);

        $resp = $de_queue->popRear();
        $this->assertEquals(\DEQue\ErrCode::TRYLOCK_TIMEOUT, $resp->error());
        $this->assertEquals(\DEQue\ErrCode::msg(\DEQue\ErrCode::TRYLOCK_TIMEOUT), $resp->errMsg());
    }

    /**
     * @covers \DEQue\Queue::clear
     */
    public function testClearLockTimeout()
    {
        // mock mutex lock
        $mock_lock = $this->getMockBuilder('\DEQue\MutexLock')
                          ->setConstructorArgs(['double_queue:1:10'])
                          ->setMethods(['lock'])
                          ->getMock();
        $mock_lock->expects($this->any())
                  ->method('lock')
                  ->willReturn(false);

        $de_queue = \DEQue\Queue::getInstance('double_queue', \DEQue\Type::UNRESTRICTED, 10);

        // 修改 mutex 属性
        \Tests\Utils\PHPUnitExtension::setVariable($de_queue, 'mutex', $mock_lock);

        $resp = $de_queue->clear();
        $this->assertSame(false, $resp);
    }
}