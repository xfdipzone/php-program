<?php
namespace Captcha\Storage;

/**
 * Captcha 验证码存储工厂类
 * 用于创建验证码存储类对象
 *
 * @author fdipzone
 * @DateTime 2023-05-20 23:24:42
 *
 */
class Factory{

    /**
     * 根据类型创建Captcha存储类对象
     *
     * @author fdipzone
     * @DateTime 2023-05-20 23:41:27
     *
     * @param string $type captcha存储类型 在 \Captcha\Storage\Type 中定义
     * @param IStorageConfig $config captcha存储类配置
     * * @return IStorage
     */
    public static function make(string $type, IStorageConfig $config):IStorage{
        try{
            $class = self::getStorageClass($type);
            return new $class($config);
        }catch(\Throwable $e){
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * 根据类型获取Captcha存储类
     *
     * @author fdipzone
     * @DateTime 2023-05-20 23:39:07
     *
     * @param string $type captcha存储类型 在 \Captcha\Storage\Type 中定义
     * @return string
     */
    private static function getStorageClass(string $type):string{
        if(isset(Type::$lookup[$type])){
            return Type::$lookup[$type];
        }else{
            throw new \Exception(sprintf('%s type captcha storage not exists', $type));
        }
    }

}