<?php
namespace Geocoding;

/**
 * 定义地理位置服务接口
 * 地理位置服务需要实现接口定义的方法
 *
 * @author fdipzone
 * @DateTime 2024-07-04 17:34:09
 *
 */
interface IGeocoding
{
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
    public function getAddressComponent(float $longitude, float $latitude, int $extensions_poi=0):\Geocoding\AddressComponentResponse;

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
    public function getLocation(string $address, string $city=''):\Geocoding\LocationResponse;
}