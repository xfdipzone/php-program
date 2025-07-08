<?php
namespace MQ;

/**
 * Message Queue 工厂类
 * 用于根据类型创建 Message Queue 组件对象
 *
 * @author fdipzone
 * @DateTime 2025-07-08 13:25:25
 *
 */
class Factory
{
    /**
     * 创建 Message Queue 组件对象
     *
     * @author fdipzone
     * @DateTime 2025-07-08 13:25:55
     *
     * @param string $type 组件类型，在 \MQ\Type 中定义
     * @return \MQ\IMessageQueue
     */
    final static function make(string $type):\MQ\IMessageQueue
    {
        try
        {
            // 根据类型获取 Message Queue 组件类
            $mq_class = self::getMQClass($type);

            // 创建 Message Queue 组件对象
            $mq = new $mq_class;

            return $mq;
        }
        catch(\Throwable $e)
        {
            throw new \MQ\Exception\FactoryException($e->getMessage());
        }
    }

    /**
     * 获取类型对应的 Message Queue 组件类
     *
     * @author fdipzone
     * @DateTime 2025-07-08 13:21:07
     *
     * @param string $type 组件类型，在 \MQ\Type 中定义
     * @return string
     */
    final static function getMQClass(string $type):string
    {
        if(isset(\MQ\Type::$map[$type]))
        {
            return \MQ\Type::$map[$type];
        }
        else
        {
            throw new \MQ\Exception\TypeException(sprintf('%s type not exists', $type));
        }
    }
}