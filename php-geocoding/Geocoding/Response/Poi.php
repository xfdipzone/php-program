<?php
namespace Geocoding\Response;

/**
 * POI 结构
 *
 * @author fdipzone
 * @DateTime 2024-07-07 21:24:42
 *
 */
class Poi
{
    /**
     * POI 地址
     *
     * @var string
     */
    private $addr = '';

    /**
     * POI 名称
     *
     * @var string
     */
    private $name = '';

    /**
     * POI 类型
     *
     * @var string
     */
    private $tag = '';

    /**
     * 地址坐标经度
     *
     * @var float
     */
    private $lng = 0;

    /**
     * 地址坐标维度
     *
     * @var float
     */
    private $lat = 0;

    /**
     * 当前坐标点的方向
     *
     * @var string
     */
    private $direction = '';

    /**
     * 离坐标点距离
     *
     * @var string
     */
    private $distance = '';

    /**
     * 初始化
     *
     * @author fdipzone
     * @DateTime 2024-07-07 22:01:02
     *
     * @param string $addr POI 地址
     * @param string $name POI 名称
     * @param string $tag POI 类型
     */
    public function __construct(string $addr, string $name, string $tag)
    {
        $this->addr = $addr;
        $this->name = $name;
        $this->tag = $tag;
    }

    /**
     * 获取 POI 地址
     *
     * @author fdipzone
     * @DateTime 2024-07-07 22:00:38
     *
     * @return string
     */
    public function addr():string
    {
        return $this->addr;
    }

    /**
     * 获取 POI 名称
     *
     * @author fdipzone
     * @DateTime 2024-07-07 22:01:35
     *
     * @return string
     */
    public function name():string
    {
        return $this->name;
    }

    /**
     * 获取 POI 类型
     *
     * @author fdipzone
     * @DateTime 2024-07-07 22:01:45
     *
     * @return string
     */
    public function tag():string
    {
        return $this->tag;
    }

    /**
     * 设置 POI 坐标
     *
     * @author fdipzone
     * @DateTime 2024-07-07 21:49:07
     *
     * @param float $lng 经度
     * @param float $lat 维度
     * @return void
     */
    public function setPoint(float $lng, float $lat):void
    {
        $this->lng = $lng;
        $this->lat = $lat;
    }

    /**
     * 获取 POI 坐标
     *
     * @author fdipzone
     * @DateTime 2024-07-07 21:49:47
     *
     * @return array
     * [lng=>xxx, lat=>xxx]
     */
    public function point():array
    {
        return array(
            'lng' => $this->lng,
            'lat' => $this->lat,
        );
    }

    /**
     * 设置当前坐标点的方向
     *
     * @author fdipzone
     * @DateTime 2024-07-07 22:02:47
     *
     * @param string $direction 方向
     * @return void
     */
    public function setDirection(string $direction):void
    {
        $this->direction = $direction;
    }

    /**
     * 获取当前坐标点的方向
     *
     * @author fdipzone
     * @DateTime 2024-07-07 22:09:53
     *
     * @return string
     */
    public function direction():string
    {
        return $this->direction;
    }

    /**
     * 设置离坐标点距离
     *
     * @author fdipzone
     * @DateTime 2024-07-07 22:11:07
     *
     * @param string $distance 距离
     * @return void
     */
    public function setDistance(string $distance):void
    {
        $this->distance = $distance;
    }

    /**
     * 获取离坐标点距离
     *
     * @author fdipzone
     * @DateTime 2024-07-07 22:11:45
     *
     * @return string
     */
    public function distance():string
    {
        return $this->distance;
    }
}