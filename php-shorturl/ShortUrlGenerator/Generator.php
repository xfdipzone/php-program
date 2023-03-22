<?php
namespace ShortUrlGenerator;

/**
 * 短链接生成器工厂类
 *
 * @author fdipzone
 * @DateTime 2023-03-22 21:43:36
 *
 */
class Generator{

    /**
     * 创建短链接生成器对象
     *
     * @author fdipzone
     * @DateTime 2023-03-22 21:44:14
     *
     * @param string $type 生成器类型
     * @param array $config 生成器初始化配置
     * @return IGenerator
     */
    public static function make(string $type, array $config):IGenerator{
        try{
            $class = Type::getGeneratorClass($type);
            return new $class($config);
        }catch(\Throwable $e){
            throw new \Exception($e->getMessage());
        }
    }

}