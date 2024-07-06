<?php
namespace Geocoding\Response;

/**
 * 地址结构
 *
 * @author fdipzone
 * @DateTime 2024-07-06 19:11:29
 *
 */
class AddressComponent
{
    /**
     * 国家
     *
     * @var string
     */
    private $country = '';

    /**
     * 省份
     *
     * @var string
     */
    private $province = '';

    /**
     * 城市
     *
     * @var string
     */
    private $city = '';

    /**
     * 区县名
     *
     * @var string
     */
    private $district = '';

    /**
     * 乡镇名
     *
     * @var string
     */
    private $town = '';

    /**
     * 道路名
     *
     * @var string
     */
    private $street = '';

    /**
     * 道路门牌号
     *
     * @var string
     */
    private $street_number = '';

    /**
     * 行政区代码
     *
     * @var string
     */
    private $adcode = '';

    /**
     * 相对当前坐标点的距离，当有门牌号的时候返回数据
     *
     * @var string
     */
    private $distance = '';

    /**
     * 相对当前坐标点的方向，当有门牌号的时候返回数据
     *
     * @var string
     */
    private $direction = '';

    /**
     * 初始化
     *
     * @author fdipzone
     * @DateTime 2024-07-06 19:23:58
     *
     * @param string $country 国家
     * @param string $province 省份
     * @param string $city 城市
     * @param string $district 区县名
     */
    public function __construct(string $country, string $province, string $city, string $district)
    {
        $this->country = $country;
        $this->province = $province;
        $this->city = $city;
        $this->district = $district;
    }

    /**
     * 获取国家
     *
     * @author fdipzone
     * @DateTime 2024-07-06 19:29:52
     *
     * @return string
     */
    public function country():string
    {
        return $this->country;
    }

    /**
     * 获取省份
     *
     * @author fdipzone
     * @DateTime 2024-07-06 19:29:58
     *
     * @return string
     */
    public function province():string
    {
        return $this->province;
    }

    /**
     * 获取城市
     *
     * @author fdipzone
     * @DateTime 2024-07-06 19:30:06
     *
     * @return string
     */
    public function city():string
    {
        return $this->city;
    }

    /**
     * 获取区县名
     *
     * @author fdipzone
     * @DateTime 2024-07-06 19:30:14
     *
     * @return string
     */
    public function district():string
    {
        return $this->district;
    }

    /**
     * 设置乡镇名
     *
     * @author fdipzone
     * @DateTime 2024-07-06 19:30:38
     *
     * @param string $town 乡镇名
     * @return void
     */
    public function setTown(string $town):void
    {
        $this->town = $town;
    }

    /**
     * 获取乡镇名
     *
     * @author fdipzone
     * @DateTime 2024-07-06 19:31:11
     *
     * @return string
     */
    public function town():string
    {
        return $this->town;
    }

    /**
     * 设置道路名
     *
     * @author fdipzone
     * @DateTime 2024-07-06 19:33:42
     *
     * @param string $street 道路名
     * @return void
     */
    public function setStreet(string $street):void
    {
        $this->street = $street;
    }

    /**
     * 获取道路名
     *
     * @author fdipzone
     * @DateTime 2024-07-06 19:34:03
     *
     * @return string
     */
    public function street():string
    {
        return $this->street;
    }

    /**
     * 设置道路门牌号
     *
     * @author fdipzone
     * @DateTime 2024-07-06 19:34:15
     *
     * @param string $street_number 道路门牌号
     * @return void
     */
    public function setStreetNumber(string $street_number):void
    {
        $this->street_number = $street_number;
    }

    /**
     * 获取道路门牌号
     *
     * @author fdipzone
     * @DateTime 2024-07-06 19:34:32
     *
     * @return string
     */
    public function streetNumber():string
    {
        return $this->street_number;
    }

    /**
     * 设置行政区代码
     *
     * @author fdipzone
     * @DateTime 2024-07-06 19:34:43
     *
     * @param string $adcode 行政区代码
     * @return void
     */
    public function setAdcode(string $adcode):void
    {
        $this->adcode = $adcode;
    }

    /**
     * 获取行政区代码
     *
     * @author fdipzone
     * @DateTime 2024-07-06 19:35:00
     *
     * @return string
     */
    public function adcode():string
    {
        return $this->adcode;
    }

    /**
     * 设置相对当前坐标点的距离
     *
     * @author fdipzone
     * @DateTime 2024-07-06 19:35:18
     *
     * @param string $distance 距离
     * @return void
     */
    public function setDistance(string $distance):void
    {
        $this->distance = $distance;
    }

    /**
     * 获取相对当前坐标点的距离
     *
     * @author fdipzone
     * @DateTime 2024-07-06 19:35:42
     *
     * @return string
     */
    public function distance():string
    {
        return $this->distance;
    }

    /**
     * 设置相对当前坐标点的方向
     *
     * @author fdipzone
     * @DateTime 2024-07-06 19:35:58
     *
     * @param string $direction 方向
     * @return void
     */
    public function setDirection(string $direction):void
    {
        $this->direction = $direction;
    }

    /**
     * 获取相对当前坐标点的方向
     *
     * @author fdipzone
     * @DateTime 2024-07-06 19:36:14
     *
     * @return string
     */
    public function direction():string
    {
        return $this->direction;
    }
}