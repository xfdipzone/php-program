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
     * 百度地理位置服务配置
     *
     * @var \Geocoding\Config\BaiduGeocodingConfig
     */
    private $config;

    /**
     * 初始化
     *
     * @author fdipzone
     * @DateTime 2024-07-04 19:48:48
     *
     * @param string $ak application key
     */
    public function __construct(\Geocoding\Config\BaiduGeocodingConfig $config)
    {
        $this->config = $config;
    }

    /**
     * 根据坐标获取地址，城市，及周边数据（全球逆地理编码）
     *
     * @author fdipzone
     * @DateTime 2024-07-04 19:30:14
     *
     * @param float $longitude 经度
     * @param float $latitude 纬度
     * @param int $extensions_poi 是否返回周边数据 在 \Geocoding\ExtensionsPoi 中定义
     * @return \Geocoding\AddressComponentResponse
     */
    public function getAddressComponent(float $longitude, float $latitude, int $extensions_poi=\Geocoding\ExtensionsPoi::NO_POI):\Geocoding\AddressComponentResponse
    {
        // 请求参数
        $request = array(
            'ak' => $this->config->ak(),
            'coordtype' => 'wgs84ll',
            'location' => $latitude.','.$longitude,
            'output' => 'json',
            'extensions_poi' => $extensions_poi,
        );

        // 发起请求
        $ret = \Geocoding\Utils::HttpRequest($this->config->reverseGeocodingApi(), $request, $this->config->timeout());

        $response = new \Geocoding\AddressComponentResponse($ret['error'], $ret['err_msg'], $ret['response']);
        return $response;
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
        // 请求参数
        $request = array(
            'ak' => $this->config->ak(),
            'address' => $address,
            'city' => $city,
            'output' => $this->config->output(),
        );

        // 发起请求
        $ret = \Geocoding\Utils::HttpRequest($this->config->geocodingApi(), $request, $this->config->timeout());

        $response = new \Geocoding\LocationResponse($ret['error'], $ret['err_msg'], $ret['response']);
        return $response;
    }
}