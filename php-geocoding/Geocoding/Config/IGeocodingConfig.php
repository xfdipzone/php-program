<?php
namespace Geocoding\Config;

/**
 * 定义地理位置服务配置接口
 * 这是一个标记接口
 *
 * @author fdipzone
 * @DateTime 2024-07-05 12:38:00
 *
 */
interface IGeocodingConfig
{
    /**
     * 获取配置名称
     *
     * @author fdipzone
     * @DateTime 2024-07-05 12:40:39
     *
     * @return string
     */
    public function name():string;
}