<?php
namespace FileParser;

/**
 * 解析器工厂类
 * 用于创建解析器对象
 *
 * @author fdipzone
 * @DateTime 2024-09-02 17:37:28
 *
 */
class Factory
{
    /**
     * 保存已创建的解析器实例
     *
     * @var array
     */
    private static $instances = [];

    /**
     * 根据类型创建解析器对象
     *
     * @author fdipzone
     * @DateTime 2024-09-02 17:38:53
     *
     * @param string $type 解析器类型 在 \FileParser\Type 中定义
     * @return \FileParser\IFileParser
     */
    public static function make(string $type):\FileParser\IFileParser
    {
        try
        {
            // 实例不存在
            if(!isset(self::$instances[$type]))
            {
                // 获取类型对应的解析器类
                $class = self::getParserClass($type);

                // 创建解析器实例
                self::$instances[$type] = new $class;
            }

            return self::$instances[$type];
        }
        catch(\Throwable $e)
        {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * 根据类型获取解析器类
     *
     * @author fdipzone
     * @DateTime 2024-09-02 17:41:00
     *
     * @param string $type 解析器类型 在 \FileParser\Type 中定义
     * @return string
     */
    final public static function getParserClass(string $type):string
    {
        if(isset(\FileParser\Type::$map[$type]))
        {
            return \FileParser\Type::$map[$type];
        }

        throw new \Exception(sprintf('file parser factory: type %s not exists', $type));
    }
}