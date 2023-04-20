<?php
namespace Thumbnail;

/**
 * 缩略图生成器组件工厂类
 *
 * @author fdipzone
 * @DateTime 2023-04-10 21:40:44
 *
 */
class Factory{

    /**
     * 根据类型创建缩略图组件对象
     *
     * @author fdipzone
     * @DateTime 2023-04-10 21:42:24
     *
     * @param string $type   缩略图组件类型
     * @param Config $config 缩略图配置
     * @return IThumbnail
     */
    public static function make(string $type, Config $config):IThumbnail{
        try{
            $class = self::getThumbnailClass($type);
            return new $class($config);
        }catch(\Throwable $e){
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * 根据类型获取缩略图组件类
     *
     * @author fdipzone
     * @DateTime 2023-04-10 21:43:47
     *
     * @param string $type 缩略图组件类型
     * @return string
     */
    private static function getThumbnailClass(string $type):string{
        if(isset(Type::$lookup[$type])){
            return Type::$lookup[$type];
        }else{
            throw new \Exception(sprintf('%s type thumbnail not exists', $type));
        }
    }

}