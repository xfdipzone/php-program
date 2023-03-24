<?php
namespace FileContentOrganization;

/**
 * 处理器工厂类
 * 用于创建处理器对象
 *
 * @author fdipzone
 * @DateTime 2023-03-24 19:26:52
 *
 */
class Factory{

    /**
     * 根据类型创建处理器对象
     *
     * @author fdipzone
     * @DateTime 2023-03-24 19:27:19
     *
     * @param string $type 处理器类型
     * @return IHandler
     */
    public static function make(string $type):IHandler{
        try{
            $class = self::getHandlerClass($type);
            $handler = new $class;
            return $handler;
        }catch(\Throwable $e){
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * 根据类型获取处理器类
     *
     * @author fdipzone
     * @DateTime 2023-03-24 19:28:28
     *
     * @param string $type 处理器类型
     * @return string
     */
    private static function getHandlerClass(string $type):string{
        if(isset(TYPE::$lookup[$type])){
            return TYPE::$lookup[$type];
        }else{
            throw new \Exception(sprintf('%s type handler class not exists', $type));
        }
    }

}