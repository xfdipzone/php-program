<?php
namespace MQ;

/**
 * 消息队列组件类型
 *
 * @author fdipzone
 * @DateTime 2025-01-25 20:15:46
 *
 */
class Type
{
    // 基于 MySQL 存储的消息队列组件
    const MYSQL = 'mysql';

    // 类型与实现类对应关系
    public static $map = [
        self::MYSQL => '\MQ\MySQL\MySqlMessageQueue',
    ];
}