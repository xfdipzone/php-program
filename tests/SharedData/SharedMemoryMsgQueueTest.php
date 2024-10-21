<?php declare(strict_types=1);
namespace Tests\SharedData;

/**
 * 测试 php-shared-data\SharedData\SharedMemoryMsgQueue
 *
 * @author fdipzone
 */
final class SharedMemoryMsgQueueTest extends \Tests\SharedData\AbstractSharedMemoryTestCase
{
    /**
     * @covers \SharedData\SharedMemoryMsgQueue::__construct
     */
    public function testConstruct()
    {
        $queue_name = $this->generateSharedKey();
        $max_message_size = 128;
        $shared_memory_msg_queue = new \SharedData\SharedMemoryMsgQueue($queue_name, $max_message_size, true);
        $this->assertEquals('SharedData\SharedMemoryMsgQueue', get_class($shared_memory_msg_queue));
    }

    /**
     * @covers \SharedData\SharedMemoryMsgQueue::__construct
     */
    public function testConstructQueueNameException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('shared memory msg queue: queue name is empty');

        $queue_name = '';
        $max_message_size = 128;
        new \SharedData\SharedMemoryMsgQueue($queue_name, $max_message_size, true);
    }

    /**
     * @covers \SharedData\SharedMemoryMsgQueue::__construct
     */
    public function testConstructMaxMessageSizeException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('shared memory msg queue: max message size must be greater than 0');

        $queue_name = $this->generateSharedKey();
        $max_message_size = 0;
        new \SharedData\SharedMemoryMsgQueue($queue_name, $max_message_size, true);
    }

    /**
     * @covers \SharedData\SharedMemoryMsgQueue::__construct
     */
    public function testConstructCreateShmIpcFileException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('shared memory msg queue: shm ipc file already exists or create fail');

        $queue_name = $this->generateSharedKey();
        $max_message_size = 128;

        // 预先创建共享内存 IPC 文件
        file_put_contents('/tmp/'.$queue_name.'-queue.ipc', '');

        new \SharedData\SharedMemoryMsgQueue($queue_name, $max_message_size, true);
    }

    /**
     * @covers \SharedData\SharedMemoryMsgQueue::__construct
     */
    public function testConstructShmIpcFileException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('shared memory msg queue: shm ipc file not exists');

        $queue_name = $this->generateSharedKey();
        $max_message_size = 128;

        new \SharedData\SharedMemoryMsgQueue($queue_name, $max_message_size);
    }

    /**
     * @covers \SharedData\SharedMemoryMsgQueue::send
     */
    public function testSend()
    {
        $queue_name = $this->generateSharedKey();
        $max_message_size = 128;
        $shared_memory_msg_queue = new \SharedData\SharedMemoryMsgQueue($queue_name, $max_message_size, true);

        // 发送消息
        $message = 'shared memory msg content';
        $ret = $shared_memory_msg_queue->send($message);
        $this->assertTrue($ret);

        // 关闭消息队列
        $closed = $shared_memory_msg_queue->close();
        $this->assertTrue($closed);
    }

    /**
     * @covers \SharedData\SharedMemoryMsgQueue::send
     */
    public function testSendMessageEmptyException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('shared memory msg queue: message is empty');

        $queue_name = $this->generateSharedKey();
        $max_message_size = 128;
        $shared_memory_msg_queue = new \SharedData\SharedMemoryMsgQueue($queue_name, $max_message_size, true);

        $message = '';
        $shared_memory_msg_queue->send($message);
    }

    /**
     * @covers \SharedData\SharedMemoryMsgQueue::send
     */
    public function testSendMessageSizeException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('shared memory msg queue: message length more than max message size');

        $queue_name = $this->generateSharedKey();
        $max_message_size = 3;
        $shared_memory_msg_queue = new \SharedData\SharedMemoryMsgQueue($queue_name, $max_message_size, true);

        $message = 'abcde';
        $shared_memory_msg_queue->send($message);
    }

    /**
     * @covers \SharedData\SharedMemoryMsgQueue::send
     */
    public function testSendShmKeyException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('shared memory msg queue: msg key invalid');

        $queue_name = $this->generateSharedKey();
        $max_message_size = 128;
        $shared_memory_msg_queue = new \SharedData\SharedMemoryMsgQueue($queue_name, $max_message_size, true);

        // 发送消息
        $message = 'shared memory msg content';
        $ret = $shared_memory_msg_queue->send($message);
        $this->assertTrue($ret);

        // 关闭消息队列
        $closed = $shared_memory_msg_queue->close();
        $this->assertTrue($closed);

        // 关闭之后再执行发送
        $shared_memory_msg_queue->send($message);
    }

    /**
     * @covers \SharedData\SharedMemoryMsgQueue::send
     */
    public function testSendException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('shared memory msg queue: msg queue create fail');

        $queue_name = $this->generateSharedKey();
        $max_message_size = 128;

        $mock_msg_queue = $this->getMockBuilder('\SharedData\SharedMemoryMsgQueue')
                               ->setConstructorArgs([$queue_name, $max_message_size, true])
                               ->setMethods(['getQueue'])
                               ->getMock();
        $mock_msg_queue->expects($this->any())
                       ->method('getQueue')
                       ->willReturn(false);

        // 发送消息
        $message = 'shared memory msg content';
        $mock_msg_queue->send($message);
    }

    /**
     * @covers \SharedData\SharedMemoryMsgQueue::receive
     */
    public function testReceive()
    {
        $queue_name = $this->generateSharedKey();
        $max_message_size = 128;
        $shared_memory_msg_queue = new \SharedData\SharedMemoryMsgQueue($queue_name, $max_message_size, true);

        // 发送消息
        $message = 'shared memory msg content';
        $shared_memory_msg_queue->send($message);

        // 接收消息
        $receive_message = $shared_memory_msg_queue->receive();
        $this->assertEquals($message, $receive_message);

        // 关闭共享内存
        $closed = $shared_memory_msg_queue->close();
        $this->assertTrue($closed);
    }

    /**
     * @covers \SharedData\SharedMemoryMsgQueue::receive
     */
    public function testReceiveShmKeyException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('shared memory msg queue: msg key invalid');

        $queue_name = $this->generateSharedKey();
        $max_message_size = 128;
        $shared_memory_msg_queue = new \SharedData\SharedMemoryMsgQueue($queue_name, $max_message_size, true);

        // 发送消息
        $message = 'shared memory msg content';
        $shared_memory_msg_queue->send($message);

        // 关闭共享内存
        $closed = $shared_memory_msg_queue->close();
        $this->assertTrue($closed);

        // 关闭之后再执行接收
        $shared_memory_msg_queue->receive();
    }

    /**
     * @covers \SharedData\SharedMemoryMsgQueue::receive
     */
    public function testReceiveException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('shared memory msg queue: get msg queue fail');

        $queue_name = $this->generateSharedKey();
        $max_message_size = 128;

        $mock_msg_queue = $this->getMockBuilder('\SharedData\SharedMemoryMsgQueue')
                               ->setConstructorArgs([$queue_name, $max_message_size, true])
                               ->setMethods(['getQueue'])
                               ->getMock();
        $mock_msg_queue->expects($this->any())
                       ->method('getQueue')
                       ->willReturn(false);

        // 接收消息
        $mock_msg_queue->receive();
    }

    /**
     * @covers \SharedData\SharedMemoryMsgQueue::receive
     */
    public function testReceiveNoMessageException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage(sprintf('shared memory msg queue: receive fail, error code %s', MSG_ENOMSG));

        $queue_name = $this->generateSharedKey();
        $max_message_size = 128;
        $shared_memory_msg_queue = new \SharedData\SharedMemoryMsgQueue($queue_name, $max_message_size, true);

        // 接收消息，不等待，没有消息错误码 MSG_ENOMSG
        $shared_memory_msg_queue->receive();
    }

    /**
     * @covers \SharedData\SharedMemoryMsgQueue::close
     */
    public function testClose()
    {
        $queue_name = $this->generateSharedKey();
        $max_message_size = 128;
        $shared_memory_msg_queue = new \SharedData\SharedMemoryMsgQueue($queue_name, $max_message_size, true);

        // 发送消息
        $message = 'shared memory msg content';
        $shared_memory_msg_queue->send($message);

        // 关闭共享内存
        $closed = $shared_memory_msg_queue->close();
        $this->assertTrue($closed);
    }

    /**
     * @covers \SharedData\SharedMemoryMsgQueue::close
     */
    public function testCloseShmKeyException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('shared memory msg queue: msg key invalid');

        $queue_name = $this->generateSharedKey();
        $max_message_size = 128;
        $shared_memory_msg_queue = new \SharedData\SharedMemoryMsgQueue($queue_name, $max_message_size, true);

        // 发送消息
        $message = 'shared memory msg content';
        $shared_memory_msg_queue->send($message);

        // 关闭共享内存
        $closed = $shared_memory_msg_queue->close();
        $this->assertTrue($closed);

        // 关闭之后再执行关闭
        $shared_memory_msg_queue->close();
    }

    /**
     * @covers \SharedData\SharedMemoryMsgQueue::close
     */
    public function testCloseException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('shared memory msg queue: get msg queue fail');

        $queue_name = $this->generateSharedKey();
        $max_message_size = 128;

        $mock_msg_queue = $this->getMockBuilder('\SharedData\SharedMemoryMsgQueue')
                               ->setConstructorArgs([$queue_name, $max_message_size, true])
                               ->setMethods(['getQueue'])
                               ->getMock();
        $mock_msg_queue->expects($this->any())
                       ->method('getQueue')
                       ->willReturn(false);

        // 关闭共享内存
        $mock_msg_queue->close();
    }

    /**
     * @covers \SharedData\SharedMemoryMsgQueue::getQueue
     */
    public function testGetQueue()
    {
        $queue_name = $this->generateSharedKey();
        $max_message_size = 128;
        $shared_memory_msg_queue = new \SharedData\SharedMemoryMsgQueue($queue_name, $max_message_size, true);

        // 测试文件
        $ipc_file = '/tmp/'.$queue_name.'-queue.ipc';
        $msg_key = \SharedData\SharedMemoryUtils::shmKey($ipc_file, 'm');

        $msg_queue = \Tests\Utils\PHPUnitExtension::callMethod($shared_memory_msg_queue, 'getQueue', [$msg_key, 0666]);
        $this->assertEquals('sysvmsg queue', get_resource_type($msg_queue));
    }
}