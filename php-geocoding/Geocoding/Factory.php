<?php
namespace Geocoding;

/**
 * 地理位置服务工厂类
 * 用于创建地址位置服务
 *
 * @author fdipzone
 * @DateTime 2024-07-09 18:02:25
 *
 */
class Factory
{
    /**
     * 根据类型与配置创建地理位置服务实例
     *
     * @author fdipzone
     * @DateTime 2024-07-09 18:31:14
     *
     * @param string $type 地理位置服务类型
     * @param \Geocoding\Config\IGeocodingConfig $config 地理位置服务配置
     * @return \Geocoding\IGeocoding
     */
    public static function make(string $type, \Geocoding\Config\IGeocodingConfig $config):\Geocoding\IGeocoding
    {
        try
        {
            $class = self::getClass($type);
            return new $class($config);
        }
        catch(\Throwable $e)
        {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * 根据类型获取地理位置服务类
     *
     * @author fdipzone
     * @DateTime 2024-07-09 21:31:41
     *
     * @param string $type 地理位置服务类型
     * @return string
     */
    private static function getClass(string $type):string
    {
        if(isset(\Geocoding\Type::$map[$type]))
        {
            return \Geocoding\Type::$map[$type];
        }

        throw new \Exception('geocoding: type '.$type.' not exists');
    }
}