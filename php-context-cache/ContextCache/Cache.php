<?php
namespace ContextCache;

/**
 * 定义上下文缓存入口类
 * 用于创建上下文缓存组件实例
 *
 * @author fdipzone
 * @DateTime 2024-02-21 21:38:37
 *
 */
class Cache
{
    /**
     * 上下文缓存组件实例
     *
     * @var \ContextCache\IContextCache
     */
    private static $instance = null;

    /**
     * 获取上下文缓存组件实例（单例模式）
     *
     * @author fdipzone
     * @DateTime 2024-02-21 21:50:25
     *
     * @return \ContextCache\IContextCache
     */
    public static function GetInstance():\ContextCache\IContextCache
    {
        if(!self::$instance)
        {
            self::$instance = new \ContextCache\LocalContextCache;
        }

        return self::$instance;
    }
}