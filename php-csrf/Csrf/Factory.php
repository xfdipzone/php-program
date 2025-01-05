<?php
namespace Csrf;

/**
 * csrf token 组件工厂类
 * 根据类型创建 csrf token 组件对象
 *
 * @author fdipzone
 * @DateTime 2025-01-04 16:14:20
 *
 */
class Factory
{
    /**
     * 创建 csrf token 组件对象
     *
     * @author fdipzone
     * @DateTime 2025-01-04 16:17:47
     *
     * @param string $type 组件类型，在 \Csrf\Type 中定义
     * @param \Csrf\Config\IConfig $config 组件配置
     * @return \Csrf\ICsrf
     */
    final public static function make(string $type, \Csrf\Config\IConfig $config):\Csrf\ICsrf
    {
        try
        {
            // 根据类型获取token组件类
            $token_class = self::getTokenClass($type);

            // 创建token组件对象
            $handler = new $token_class($config);

            return $handler;
        }
        catch(\Throwable $e)
        {
            throw new \Csrf\Exception\FactoryException($e->getMessage());
        }
    }

    /**
     * 获取类型对应的 csrf token 组件类
     *
     * @author fdipzone
     * @DateTime 2025-01-04 16:19:22
     *
     * @param string $type 组件类型，在 \Csrf\Type 中定义
     * @return string
     */
    final public static function getTokenClass(string $type):string
    {
        if(isset(\Csrf\Type::$map[$type]))
        {
            return \Csrf\Type::$map[$type];
        }
        else
        {
            throw new \Csrf\Exception\TypeException('csrf type not exists');
        }
    }
}
