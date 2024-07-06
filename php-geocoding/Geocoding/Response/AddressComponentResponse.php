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
     * @return array
     */
    public function addressComponent():array
    {
        $addressComponent = [];

        if(isset($this->response['result']['addressComponent']))
        {
            $addressComponent['country'] = $this->response['result']['addressComponent']['country'];
            $addressComponent['province'] = $this->response['result']['addressComponent']['province'];
            $addressComponent['city'] = $this->response['result']['addressComponent']['city'];
            $addressComponent['district'] = $this->response['result']['addressComponent']['district'];
            $addressComponent['town'] = $this->response['result']['addressComponent']['town'];
            $addressComponent['street'] = $this->response['result']['addressComponent']['street'];
            $addressComponent['street_number'] = $this->response['result']['addressComponent']['street_number'];
            $addressComponent['adcode'] = $this->response['result']['addressComponent']['adcode'];
            $addressComponent['distance'] = $this->response['result']['addressComponent']['distance'];
            $addressComponent['direction'] = $this->response['result']['addressComponent']['direction'];
        }

        return $addressComponent;
    }
}