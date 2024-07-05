<?php
namespace Geocoding\Config;

/**
 * 百度地理位置服务配置
 *
 * @author fdipzone
 * @DateTime 2024-07-05 12:16:55
 *
 */
class BaiduGeocodingConfig implements \Geocoding\Config\IGeocodingConfig
{
    /**
     * 配置名称
     *
     * @var string
     */
    private $name = 'baidu config';

    /**
     * 百度 application key
     *
     * @var string
     */
    private $ak;

    /**
     * 逆地理编码 API
     *
     * @var string
     */
    private $reverse_geocoding_api = 'https://api.map.baidu.com/reverse_geocoding/v3/';

    /**
     * 地理编码 API
     *
     * @var string
     */
    private $geocoding_api = 'https://api.map.baidu.com/geocoding/v3/';

    /**
     * 输出格式
     * json/xml
     *
     * @var string
     */
    private $output = 'json';

    /**
     * 请求超时时间
     *
     * @var int
     */
    private $timeout = 5;

    /**
     * 初始化 设置 application key
     *
     * @author fdipzone
     * @DateTime 2024-07-05 12:20:40
     *
     * @param string $ak
     */
    public function __construct(string $ak)
    {
        if(empty($ak))
        {
            throw new \Exception('baidu-geocoding-config: application key is empty');
        }

        $this->ak = $ak;
    }

    /**
     * 获取配置名称
     *
     * @author fdipzone
     * @DateTime 2024-07-05 12:44:07
     *
     * @return string
     */
    public function name():string
    {
        return $this->name;
    }

    /**
     * 获取 application key
     *
     * @author fdipzone
     * @DateTime 2024-07-05 12:24:19
     *
     * @return string
     */
    public function ak():string
    {
        return $this->ak;
    }

    /**
     * 获取逆地理编码 API
     *
     * @author fdipzone
     * @DateTime 2024-07-05 12:24:28
     *
     * @return string
     */
    public function reverseGeocodingApi():string
    {
        return $this->reverse_geocoding_api;
    }

    /**
     * 获取地理编码 API
     *
     * @author fdipzone
     * @DateTime 2024-07-05 12:25:28
     *
     * @return string
     */
    public function geocodingApi():string
    {
        return $this->geocoding_api;
    }

    /**
     * 获取输出格式
     *
     * @author fdipzone
     * @DateTime 2024-07-05 21:29:42
     *
     * @return string
     */
    public function output():string
    {
        return $this->output;
    }

    /**
     * 获取请求超时时间
     *
     * @author fdipzone
     * @DateTime 2024-07-05 12:58:27
     *
     * @return int
     */
    public function timeout():int
    {
        return $this->timeout;
    }
}