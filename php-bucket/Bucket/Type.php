<?php
namespace Bucket;

/**
 * 定义bucket类型
 *
 * @author fdipzone
 * @DateTime 2023-04-01 17:29:17
 *
 */
class Type{

    // redis bucket
    const REDIS = 'redis';

    // 类型与实现类对应关系
    public static $lookup = array(
        self::REDIS => 'Bucket\\RedisBucket'
    );

}