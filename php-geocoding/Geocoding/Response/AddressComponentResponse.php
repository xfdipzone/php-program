<?php
namespace Geocoding\Response;

/**
 * 定义逆地址编码返回结构
 * 坐标转地址信息
 *
 * @author fdipzone
 * @DateTime 2024-07-04 17:51:10
 *
 */
class AddressComponentResponse
{
    /**
     * 错误码
     *
     * @var int
     */
    private $error;

    /**
     * 错误信息
     *
     * @var string
     */
    private $err_msg;

    /**
     * 响应原始数据
     * Json String
     *
     * @var string
     */
    private $raw_response;

    /**
     * 响应数据
     * 响应原始数据 JSON Decode 后的数据
     *
     * @var array
     */
    private $response = [];

    /**
     * 地址结构
     *
     * @var \Geocoding\Response\AddressComponent
     */
    private $addressComponent;

    /**
     * 初始化
     *
     * @author fdipzone
     * @DateTime 2024-07-05 13:23:12
     *
     * @param int $error 错误码
     * @param string $err_msg 错误信息
     * @param string $raw_response 响应原始数据
     */
    public function __construct(int $error, string $err_msg, string $raw_response)
    {
        $this->error = $error;
        $this->err_msg = $err_msg;
        $this->raw_response = $raw_response;

        // 解析响应数据
        if($error==0)
        {
            $this->response = json_decode($raw_response, true);

            // 解析地址结构
            $this->parseAddressComponent();
        }
    }

    /**
     * 获取错误码
     *
     * @author fdipzone
     * @DateTime 2024-07-05 13:27:06
     *
     * @return int
     */
    public function error():int
    {
        return $this->error;
    }

    /**
     * 获取错误信息
     *
     * @author fdipzone
     * @DateTime 2024-07-05 13:27:16
     *
     * @return string
     */
    public function errMsg():string
    {
        return $this->err_msg;
    }

    /**
     * 获取原始响应数据
     *
     * @author fdipzone
     * @DateTime 2024-07-05 13:27:25
     *
     * @return string
     */
    public function rawResponse():string
    {
        return $this->raw_response;
    }

    /**
     * 获取逆地理编码状态
     *
     * @author fdipzone
     * @DateTime 2024-07-05 19:38:18
     *
     * @return int
     */
    public function status():int
    {
        return isset($this->response['status'])? $this->response['status'] : -1;
    }

    /**
     * 获取地址
     *
     * @author fdipzone
     * @DateTime 2024-07-05 19:55:36
     *
     * @return string
     */
    public function formattedAddress():string
    {
        return isset($this->response['result']['formatted_address'])? $this->response['result']['formatted_address'] : '';
    }

    /**
     * 获取商圈信息
     *
     * @author fdipzone
     * @DateTime 2024-07-05 19:57:04
     *
     * @return string
     */
    public function business():string
    {
        return isset($this->response['result']['business'])? $this->response['result']['business'] : '';
    }

    /**
     * 获取地址结构
     *
     * @author fdipzone
     * @DateTime 2024-07-05 20:02:02
     *
     * @return \Geocoding\Response\AddressComponent
     */
    public function addressComponent():\Geocoding\Response\AddressComponent
    {
        return $this->addressComponent;
    }

    /**
     * 解析地址结构
     * 创建地址结构对象
     *
     * @author fdipzone
     * @DateTime 2024-07-06 19:43:25
     *
     * @return void
     */
    private function parseAddressComponent():void
    {
        if(isset($this->response['result']['addressComponent']))
        {
            $country = $this->response['result']['addressComponent']['country'];
            $province = $this->response['result']['addressComponent']['province'];
            $city = $this->response['result']['addressComponent']['city'];
            $district = $this->response['result']['addressComponent']['district'];
            $town = $this->response['result']['addressComponent']['town'];
            $street = $this->response['result']['addressComponent']['street'];
            $street_number = $this->response['result']['addressComponent']['street_number'];
            $adcode = $this->response['result']['addressComponent']['adcode'];
            $distance = $this->response['result']['addressComponent']['distance'];
            $direction = $this->response['result']['addressComponent']['direction'];

            $addressComponent = new \Geocoding\Response\AddressComponent($country, $province, $city, $district);
            $addressComponent->setTown($town);
            $addressComponent->setStreet($street);
            $addressComponent->setStreetNumber($street_number);
            $addressComponent->setAdcode($adcode);
            $addressComponent->setDistance($distance);
            $addressComponent->setDirection($direction);

            $this->addressComponent = $addressComponent;
        }

        // 没有地址结构
        $this->addressComponent = new \Geocoding\Response\AddressComponent('', '', '', '');
    }
}