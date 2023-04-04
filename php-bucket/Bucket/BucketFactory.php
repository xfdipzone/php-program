<?php
namespace Bucket;

/**
 * Bucket工厂类
 *
 * @author fdipzone
 * @DateTime 2023-04-01 17:39:21
 *
 */
class BucketFactory{

    /**
     * 根据类型创建bucket类对象
     *
     * @author fdipzone
     * @DateTime 2023-04-01 19:21:32
     *
     * @param string $type bucket类型
     * @param IBucketConfig $config bucket组件配置
     * @return IBucket
     */
    public static function make(string $type, IBucketConfig $config):IBucket{
        try{
            $class = self::getBucketClass($type);
            return new $class($config);
        }catch(\Throwable $e){
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * 根据类型获取bucket类
     *
     * @author fdipzone
     * @DateTime 2023-04-01 19:22:15
     *
     * @param string $type bucket类型
     * @return string
     */
    private static function getBucketClass(string $type):string{
        if(isset(Type::$lookup[$type])){
            return Type::$lookup[$type];
        }else{
            throw new \Exception(sprintf('%s type bucket not exists', $type));
        }
    }

}