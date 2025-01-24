<?php declare(strict_types=1);
namespace Tests\MQ;

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-message\MQ\MessageBody
 *
 * @author fdipzone
 */
final class MessageBodyTest extends TestCase
{
    /**
     * @covers \MQ\MessageBody::__construct
     */
    public function testConstruct()
    {
        $topic = 'test_topic';
        $id = "msg-1001";
        $data = "message content";

        $message_body = new \MQ\MessageBody($topic, $id, $data);
        $this->assertEquals('MQ\MessageBody', get_class($message_body));
    }

    /**
     * @covers \MQ\MessageBody::__construct
     * @dataProvider constructExceptionCases
     */
    public function testConstructException(callable $func, string $exception_message)
    {
        $this->expectException(\MQ\Exception\MessageBodyException::class);
        $this->expectExceptionMessage($exception_message);
        $func();
    }

    // construct 异常测试用例集合
    public function constructExceptionCases():array
    {
        // 异常情况
        $exception_cases = array(
            array(
                function()
                {
                    new \MQ\MessageBody('', 'msg-1001', 'message content');
                },
                'message topic is empty',
            ),
            array(
                function()
                {
                    new \MQ\MessageBody('test_topic', '', 'message content');
                },
                'message id is empty',
            ),
            array(
                function()
                {
                    new \MQ\MessageBody('test_topic', 'msg-1001', '');
                },
                'message data is empty',
            ),
        );

        return $exception_cases;
    }

    /**
     * @covers \MQ\MessageBody::setKey
     * @covers \MQ\MessageBody::topic
     * @covers \MQ\MessageBody::id
     * @covers \MQ\MessageBody::data
     * @covers \MQ\MessageBody::key
     */
    public function testSetAndGet()
    {
        $topic = 'test_topic';
        $id = "msg-1001";
        $data = "message content";
        $key = "message_key";

        $message_body = new \MQ\MessageBody($topic, $id, $data);
        $this->assertEquals($topic, $message_body->topic());
        $this->assertEquals($id, $message_body->id());
        $this->assertEquals($data, $message_body->data());

        // 没有设置 key，使用 id 代替
        $this->assertEquals($id, $message_body->key());

        $message_body->setKey($key);
        $this->assertEquals($key, $message_body->key());
    }

    /**
     * @covers \MQ\MessageBody::setKey
     */
    public function testSetKeyException()
    {
        $this->expectException(\MQ\Exception\MessageBodyException::class);
        $this->expectExceptionMessage('message key is empty');

        $topic = 'test_topic';
        $id = "msg-1001";
        $data = "message content";

        $message_body = new \MQ\MessageBody($topic, $id, $data);
        $message_body->setKey('');
    }
}