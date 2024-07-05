<?php
namespace Geocoding;

/**
 * 定义地址编码返回结构
 * 地址转坐标信息
 *
 * @author fdipzone
 * @DateTime 2024-07-04 17:49:32
 *
 */
class LocationResponse
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
     * 获取地理编码状态
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
     * 返回坐标数据
     *
     * @author fdipzone
     * @DateTime 2024-07-05 19:20:14
     *
     * @return array
     */
    public function location():array
    {
        return isset($this->response['result']['location'])? $this->response['result']['location'] : [];
    }

    /**
     * 获取位置附加信息
     * 是否精确查找
     * 1为精确查找，即准确打点
     * 0为不精确，即模糊打点
     *
     * @author fdipzone
     * @DateTime 2024-07-05 19:28:38
     *
     * @return int
     */
    public function precise():int
    {
        return isset($this->response['result']['precise'])? $this->response['result']['precise'] : 0;
    }

    /**
     * 获取坐标精度
     * 描述打点绝对精度（即坐标点的误差范围）
     *
     * @author fdipzone
     * @DateTime 2024-07-05 19:29:18
     *
     * @return int
     */
    public function confidence():int
    {
        return isset($this->response['result']['confidence'])? $this->response['result']['confidence'] : 0;
    }

    /**
     * 获取地址理解程度
     * 描述地址理解程度。分值范围0-100，分值越大，服务对地址理解程度越高
     *
     * @author fdipzone
     * @DateTime 2024-07-05 19:30:06
     *
     * @return int
     */
    public function comprehension():int
    {
        return isset($this->response['result']['comprehension'])? $this->response['result']['comprehension'] : 0;
    }

    /**
     * 获取地址类型
     *
     * @author fdipzone
     * @DateTime 2024-07-05 19:30:23
     *
     * @return string
     */
    public function level():string
    {
        return isset($this->response['result']['level'])? $this->response['result']['level'] : '';
    }
}