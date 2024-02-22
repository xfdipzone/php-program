<?php
namespace ContextCache;

/**
 * 定义上下文缓存组件类型
 *
 * @author fdipzone
 * @DateTime 2024-02-22 17:08:29
 *
 */
class Type
{
    // 本地缓存组件
    const LOCAL = 'local';

    // 类型与实现类关系
    public static $map = [
        self::LOCAL => 'ContextCache\LocalContextCache',
    ];
}