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
    public static $lookup = array(
        self::SINA => 'ShortUrlGenerator\\SinaGenerator',
    );

}

