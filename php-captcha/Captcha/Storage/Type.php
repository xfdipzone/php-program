<?php
namespace Captcha\Storage;

/**
 * 定义Captcha存储类型
 *
 * @author fdipzone
 * @DateTime 2023-05-20 23:34:59
 *
 */
class Type{

    // Session
    const SESSION = 'Session';

    // Redis
    const REDIS = 'Redis';

    // 类型与实现类对应关系
    public static $lookup = array(
        self::SESSION => 'Captcha\\Storage\\SessionStorage',
        self::REDIS => 'Captcha\\Storage\\RedisStorage',
    );

}