<?php
namespace SensitiveWordFilter\Storage;

/**
 * 定义敏感词存储类型
 *
 * @author fdipzone
 * @DateTime 2024-08-08 18:28:01
 *
 */
class Type
{
    // 基于内存存储
    const MEMORY = 'memory';

    // 类型与实现类关系
    public static $map = [
        self::MEMORY => 'SensitiveWordFilter\MemoryStorage',
    ];
}