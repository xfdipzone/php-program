<?php
namespace SharedData;

/**
 * 共享消息队列接口
 * 定义共享消息队列类需要实现的方法
 *
 * @author fdipzone
 * @DateTime 2024-10-18 21:33:39
 *
 */
interface ISharedMsgQueue
{
    /**
     * 发送消息
     *
     * @author fdipzone
     * @DateTime 2024-10-18 21:38:20
     *
     * @param string $msg 消息内容
     * @return boolean
     */
    public function send(string $msg):bool;

    /**
     * 接收消息
     *
     * @author fdipzone
     * @DateTime 2024-10-18 21:38:32
     *
     * @return string
     */
    public function receive():string;
}