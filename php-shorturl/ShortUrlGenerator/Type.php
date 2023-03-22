<?php
namespace ShortUrlGenerator;

/**
 * 短链接生成器类型
 *
 * @author fdipzone
 * @DateTime 2023-03-22 21:45:35
 *
 */
class Type{

    // 新浪微博短链接生成器
    const SINA = 'sina';

    // 类型与生成器类对应关系
    private static $lookup = array(
        self::SINA => 'ShortUrlGenerator\\SinaGenerator',
    );

    /**
     * 根据类型获取短链接生成器类
     *
     * @author fdipzone
     * @DateTime 2023-03-22 21:51:07
     *
     * @param string $type
     * @return string
     */
    public static function getGeneratorClass(string $type):string{
        if(isset(static::$lookup[$type])){
            return static::$lookup[$type];
        }else{
            throw new \Exception('generator not exists');
        }
    }

}

