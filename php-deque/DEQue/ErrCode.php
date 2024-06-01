<?php
namespace DEQue;

/**
 * 定义双向队列错误码
 *
 * @author fdipzone
 * @DateTime 2024-05-31 18:54:53
 *
 */
class ErrCode
{
    // 错误：队列已满
    const FULL = 1;

    // 错误：队列为空
    const EMPTY = 2;

    // 错误：头部入队受限
    const FRONT_ENQUEUE_RESTRICTED = 3;

    // 错误：头部出队受限
    const FRONT_DEQUEUE_RESTRICTED = 4;

    // 错误：尾部入队受限
    const REAR_ENQUEUE_RESTRICTED = 5;

    // 错误：尾部出队受限
    const REAR_DEQUEUE_RESTRICTED = 6;

    // 错误：出队端与入队端不一致
    const DIFFERENT_ENDPOINT = 7;

    // 错误码与错误信息对应关系
    private static $map = [
        self::FULL => '队列已满',
        self::EMPTY => '队列为空',
        self::FRONT_ENQUEUE_RESTRICTED => '头部入队受限',
        self::FRONT_DEQUEUE_RESTRICTED => '头部出队受限',
        self::REAR_ENQUEUE_RESTRICTED => '尾部入队受限',
        self::REAR_DEQUEUE_RESTRICTED => '尾部出队受限',
        self::DIFFERENT_ENDPOINT => '出队端与入队端不一致',
    ];

    /**
     * 获取错误码对应的错误信息
     *
     * @author fdipzone
     * @DateTime 2024-05-31 18:59:16
     *
     * @param int $error 错误码
     * @return string
     */
    public static function msg(int $error):string
    {
        if(isset(self::$map[$error]))
        {
            return self::$map[$error];
        }

        return '';
    }
}