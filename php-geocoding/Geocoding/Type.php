<?php
namespace Geocoding;

/**
 * 定义支持的地理位置服务类型
 *
 * @author fdipzone
 * @DateTime 2024-07-04 19:52:06
 *
 */
class Type
{
    // 基于百度地理位置服务
    const BAIDU = 'baidu';

    // 类型与实现类对应关系
    public static $map = [
        self::BAIDU => '\Geocoding\\BaiduGeocoding',
    ];
}