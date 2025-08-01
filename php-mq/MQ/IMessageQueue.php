<?php
namespace MQ;

/**
 * 消息队列接口
 * 定义消息队列实现类必须实现的方法
 *
 * @author fdipzone
 * @DateTime 2025-01-18 15:46:01
 *
 */
interface IMessageQueue
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
    public function produce(string $topic, \MQ\MessageBody $message_body):bool;

    /**
     * 消费主题消息
     *
     * @author fdipzone
     * @DateTime 2025-01-25 20:10:52
     *
     * @param string $topic 消息主题
     * @return \MQ\MessageBody
     */
    public function consume(string $topic):\MQ\MessageBody;
}