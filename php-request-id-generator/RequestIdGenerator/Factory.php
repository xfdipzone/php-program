<?php
namespace RequestIdGenerator;

/**
 * 请求 ID 生成器工厂类
 * 根据类型创建请求 ID 生成器
 *
 * @author fdipzone
 * @DateTime 2026-04-27 12:13:44
 *
 */
class Factory
{
    /**
     * 创建请求 ID 生成器对象
     *
     * @author fdipzone
     * @DateTime 2026-04-27 12:19:55
     *
     * @param string $type 类型，在 \RequestIdGenerator\Type 中定义
     * @param \RequestIdGenerator\Config\IRequestIdGeneratorConfig|null $config 配置
     * @return \RequestIdGenerator\IRequestIdGenerator
     */
    final public static function make(string $type, ?\RequestIdGenerator\Config\IRequestIdGeneratorConfig $config=null):\RequestIdGenerator\IRequestIdGenerator
    {
        try
        {
            // 根据类型获取请求 ID 生成器
            $generator_class = self::getGeneratorClass($type);

            // 创建请求 ID 生成器
            $generator = new $generator_class($config);

            return $generator;
        }
        catch(\Throwable $e)
        {
            throw new \RequestIdGenerator\Exception\FactoryException($e->getMessage());
        }
    }

    /**
     * 获取类型对应的请求 ID 生成器类
     *
     * @author fdipzone
     * @DateTime 2026-04-27 12:20:55
     *
     * @param string $type 类型，在 \RequestIdGenerator\Type 中定义
     * @return string
     */
    final public static function getGeneratorClass(string $type):string
    {
        if(isset(\RequestIdGenerator\Type::$map[$type]))
        {
            return \RequestIdGenerator\Type::$map[$type];
        }
        else
        {
            throw new \RequestIdGenerator\Exception\TypeException(sprintf('%s type not exists', $type));
        }
    }
}