<?php
namespace MQ;

/**
 * 消息队列工厂类
 * 根据类型创建消息队列组件对象
 *
 * @author fdipzone
 * @DateTime 2025-07-08 13:25:25
 *
 */
class Factory
{
    /**
     * 创建消息队列组件对象
     *
     * @author fdipzone
     * @DateTime 2025-07-08 13:25:55
     *
     * @param string $type 组件类型，在 \MQ\Type 中定义
     * @param \MQ\Config\IMessageQueueConfig $config 消息队列组件配置对象
     * @return \MQ\IMessageQueue
     */
    final static function make(string $type, \MQ\Config\IMessageQueueConfig $config):\MQ\IMessageQueue
    {
        try
        {
            // 根据类型获取消息队列组件类
            $mq_class = self::getMQClass($type);

            // 创建消息队列组件对象
            $mq = new $mq_class($config);

            return $mq;
        }
        catch(\Throwable $e)
        {
            throw new \MQ\Exception\FactoryException($e->getMessage());
        }
    }

    /**
     * 获取类型对应的消息队列组件类
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