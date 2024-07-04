<?php
namespace Geocoding;

/**
 * 基于百度的地理位置服务
 *
 * 百度密钥获取方法：http://lbsyun.baidu.com/apiconsole/key?application=key（需要先注册百度开发者账号，并创建服务端应用）
 *
 * 全球逆地理编码文档：https://lbs.baidu.com/faq/api?title=webapi/guide/webservice-geocoding-abroad-base
 * 地理编码文档：https://lbs.baidu.com/faq/api?title=webapi/guide/webservice-geocoding-base
 *
 * @author fdipzone
 * @DateTime 2024-07-04 19:37:09
 *
 */
class BaiduGeocoding implements \Geocoding\IGeocoding
{
    /**
     * 百度 application key
     *
     * @var string
     */
    private $ak;

    /**
     * 初始化
     *
     * @author fdipzone
     * @DateTime 2024-07-04 19:48:48
     *
     * @param string $ak application key
     */
    public function __construct(string $ak)
    {
        if(empty($ak))
        {
            throw new \Exception('baidu-geocoding: application key is empty');
        }

        $this->ak = $ak;
    }

    /**
     * 根据坐标获取地址，城市，及周边数据（全球逆地理编码）
     *
     * @author fdipzone
     * @DateTime 2024-07-04 19:30:14
     *
     * @param float $longitude 经度
     * @param float $latitude 纬度
     * @param int $extensions_poi 是否返回周边数据
     * @return \Geocoding\AddressComponentResponse
     */
    public function getAddressComponent(float $longitude, float $latitude, int $extensions_poi=0):\Geocoding\AddressComponentResponse
    {
        return new \Geocoding\AddressComponentResponse;
    }

    /**
     * 根据地址与城市获取坐标（地址编码）
     *
     * @author fdipzone
     * @DateTime 2024-07-04 19:28:58
     *
     * @param string $address 地址
     * @param string $city 城市
     * @return \Geocoding\LocationResponse
     */
    public function getLocation(string $address, string $city=''):\Geocoding\LocationResponse
    {
        return new \Geocoding\LocationResponse;
    }
}