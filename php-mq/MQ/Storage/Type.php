<?php
namespace MQ\Storage;

/**
 * 定义支持的消息存储组件类型
 *
 * @author fdipzone
 * @DateTime 2025-01-18 15:49:48
 *
 */
class Type
{
    // 使用 MySQL 存储
    const MYSQL = 'mysql';

    // 类型与实现类对应关系
    public static $map = [
        self::MYSQL => '\MQ\Storage\MySqlStorage',
    ];
}