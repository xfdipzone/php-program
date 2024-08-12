<?php
namespace SensitiveWordFilter\Storage;

/**
 * 敏感词存储工厂类
 * 用于创建敏感词存储类对象
 *
 * @author fdipzone
 * @DateTime 2024-08-11 19:23:31
 *
 */
class Factory
{
    /**
     * 根据类型创建敏感词存储类对象
     *
     * @author fdipzone
     * @DateTime 2024-08-12 15:15:19
     *
     * @param string $type 敏感词存储类型 在 \SensitiveWordFilter\Storage\Type 中定义
     * @return \SensitiveWordFilter\Storage\IStorage
     */
    public static function make(string $type):\SensitiveWordFilter\Storage\IStorage
    {
        try
        {
            $class = self::getStorageClass($type);
            return new $class;
        }
        catch(\Throwable $e)
        {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * 根据类型获取敏感词存储类
     *
     * @author fdipzone
     * @DateTime 2024-08-12 15:17:31
     *
     * @param string $type 敏感词存储类型
     * @return string
     */
    private static function getStorageClass(string $type):string
    {
        if(isset(\SensitiveWordFilter\Storage\Type::$map[$type]))
        {
            return \SensitiveWordFilter\Storage\Type::$map[$type];
        }

        throw new \Exception(sprintf('storage factory: type %s not exists', $type));
    }
}