<?php
namespace MQ;

/**
 * 消息体结构
 *
 * @author fdipzone
 * @DateTime 2025-01-23 19:02:43
 *
 */
class MessageBody
{
    /**
     * 消息主题
     *
     * @var string
     */
    private $topic;

    /**
     * 消息 Id（唯一）
     *
     * @var string
     */
    private $id;

    /**
     * 消息内容
     *
     * @var string
     */
    private $data;

    /**
     * 消息业务标识
     * 如为空则使用 id 作为标识
     * 用于保证同一业务消息有序
     *
     * @var string
     */
    private $key = '';

    /**
     * 初始化
     *
     * @author fdipzone
     * @DateTime 2025-01-23 19:14:09
     *
     * @param string $topic 消息主题
     * @param string $id 消息 Id
     * @param string $data 消息内容
     */
    public function __construct(string $topic, string $id, string $data)
    {
        if(empty($topic))
        {
            throw new \MQ\Exception\MessageBodyException('message topic is empty');
        }

        if(empty($id))
        {
            throw new \MQ\Exception\MessageBodyException('message id is empty');
        }

        if(empty($data))
        {
            throw new \MQ\Exception\MessageBodyException('message data is empty');
        }

        $this->topic = $topic;
        $this->id = $id;
        $this->data = $data;
    }

    /**
     * 设置消息业务标识
     *
     * @author fdipzone
     * @DateTime 2025-01-23 19:17:29
     *
     * @param string $key 消息业务标识
     * @return void
     */
    public function setKey(string $key):void
    {
        if(empty($key))
        {
            throw new \MQ\Exception\MessageBodyException('message key is empty');
        }

        $this->key = $key;
    }

    /**
     * 获取消息主题
     *
     * @author fdipzone
     * @DateTime 2025-01-23 19:18:28
     *
     * @return string
     */
    public function topic():string
    {
        return $this->topic;
    }

    /**
     * 获取消息 Id
     *
     * @author fdipzone
     * @DateTime 2025-01-23 19:18:34
     *
     * @return string
     */
    public function id():string
    {
        return $this->id;
    }

    /**
     * 获取消息内容
     *
     * @author fdipzone
     * @DateTime 2025-01-23 19:18:44
     *
     * @return string
     */
    public function data():string
    {
        return $this->data;
    }

    /**
     * 获取消息业务标识
     *
     * @author fdipzone
     * @DateTime 2025-01-23 19:18:50
     *
     * @return string
     */
    public function key():string
    {
        return $this->key!=''? $this->key : $this->id;
    }
}