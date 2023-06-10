<?php
namespace HttpRequest;

/**
 * 请求返回数据结构
 *
 * @author fdipzone
 * @DateTime 2023-06-08 23:15:38
 *
 */
class Response
{
    /**
     * 执行状态
     * true: 执行成功
     * false: 执行失败
     *
     * @var boolean
     */
    private $success = true;

    /**
     * 错误信息，当success=false时非空
     *
     * @var string
     */
    private $err_msg = '';

    /**
     * 返回的数据
     *
     * @var string
     */
    private $data = '';

    /**
     * 设置执行状态
     *
     * @author fdipzone
     * @DateTime 2023-06-10 22:49:42
     *
     * @param boolean $success 执行状态 true/false
     * @return void
     */
    public function setSuccess(bool $success):void
    {
        $this->success = $success;
    }

    /**
     * 获取执行状态
     *
     * @author fdipzone
     * @DateTime 2023-06-10 22:50:05
     *
     * @return boolean
     */
    public function success():bool
    {
        return $this->success;
    }

    /**
     * 设置错误信息
     *
     * @author fdipzone
     * @DateTime 2023-06-10 22:50:14
     *
     * @param string $err_msg 错误信息
     * @return void
     */
    public function setErrMsg(string $err_msg):void
    {
        if(empty($err_msg))
        {
            throw new \Exception('err msg is empty');
        }
        $this->err_msg = $err_msg;
    }

    /**
     * 获取错误信息
     *
     * @author fdipzone
     * @DateTime 2023-06-10 22:50:37
     *
     * @return string
     */
    public function errMsg():string
    {
        return $this->err_msg;
    }

    /**
     * 设置返回数据
     *
     * @author fdipzone
     * @DateTime 2023-06-10 22:50:47
     *
     * @param string $data 返回数据
     * @return void
     */
    public function setData(string $data):void
    {
        if(empty($data))
        {
            throw new \Exception('response data is empty');
        }
        $this->data = $data;
    }

    /**
     * 获取返回数据
     *
     * @author fdipzone
     * @DateTime 2023-06-10 22:51:06
     *
     * @return string
     */
    public function data():string
    {
        return $this->data;
    }
}