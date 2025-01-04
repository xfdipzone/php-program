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
    final public static function create(string $type, \Csrf\Config\IConfig $config):\Csrf\ICsrf
    {
        // 根据类型获取token组件类
        $verify_class = self::getVerifyClass($type);

        // 创建token组件对象
        try
        {
            $handler = new $verify_class($config);
        }
        catch(\Throwable $e)
        {
            throw new \Csrf\Exception\FactoryException($e->getMessage());
        }

        return $handler;
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
    final public static function getVerifyClass(string $type):string
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
