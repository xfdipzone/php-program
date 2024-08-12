<?php declare(strict_types=1);

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
    }
}