<?php
namespace MQ\MySQL;

/**
 * 基于 MySQL 存储实现的消息队列组件
 *
 * @author fdipzone
 * @DateTime 2025-01-25 20:19:51
 *
 */
class MySqlMessageQueue implements \MQ\IMessageQueue
{
    /**
     * 生产主题消息
     *
     * @author fdipzone
     * @DateTime 2025-01-25 20:11:15
     *
     * @param string $topic 消息主题
     * @param \MQ\MessageBody $message_body 消息体
     * @return boolean
     */
    public function produce(string $topic, \MQ\MessageBody $message_body):bool
    {
        return true;
    }

    /**
     * 消费主题消息
     *
     * @author fdipzone
     * @DateTime 2025-01-25 20:10:52
     *
     * @param string $topic 消息主题
     * @return \MQ\MessageBody
     */
    public function consume(string $topic):\MQ\MessageBody
    {
        return new \MQ\MessageBody('', '', '');
    }
}