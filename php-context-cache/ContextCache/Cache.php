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
     * 上下文缓存组件实例集合
     *
     * @var array [ type => \ContextCache\IContextCache ]
     */
    private static $instance = [];

    /**
     * 获取上下文缓存组件实例（单例模式）
     *
     * @author fdipzone
     * @DateTime 2024-02-21 21:50:25
     *
     * @param string $type 缓存组件类型 在 \ContextCache\Type 中定义，默认为本地缓存组件类型
     * @return \ContextCache\IContextCache
     */
    public static function getInstance(string $type = \ContextCache\Type::LOCAL):\ContextCache\IContextCache
    {
        try
        {
            // 根据类型获取缓存实现类
            $class = self::getCacheClass($type);

            if(!isset(self::$instance[$type]))
            {
                self::$instance[$type] = new $class;
            }

            return self::$instance[$type];
        }
        catch(\Throwable $e)
        {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * 根据缓存组件类型获取上下文缓存组件实现类
     *
     * @author fdipzone
     * @DateTime 2024-02-22 17:22:58
     *
     * @param string $type 缓存组件类型 在 \ContextCache\Type 中定义
     * @return string
     */
    public static function getCacheClass(string $type):string
    {
        if(isset(\ContextCache\TYPE::$map[$type]))
        {
            return \ContextCache\TYPE::$map[$type];
        }
        else
        {
            throw new \Exception(sprintf('%s type cache not exists', $type));
        }
    }
}