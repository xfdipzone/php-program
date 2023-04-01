<?php
namespace Bucket;

/**
 * 定义bucket类返回的数据结构
 *
 * @author fdipzone
 * @DateTime 2023-04-01 19:36:22
 *
 */
class Response{

    /**
     * 错误码
     * 0表示没有错误
     *
     * @var int
     */
    private $error = 0;

    /**
     * 返回的数据体
     *
     * @var mixed
     */
    private $data = [];

    /**
     * 设置错误码
     *
     * @author fdipzone
     * @DateTime 2023-04-01 19:40:58
     *
     * @param int $error 错误码
     * @return void
     */
    public function setError(int $error):void{
        $this->error = $error;
    }

    /**
     * 获取错误码
     *
     * @author fdipzone
     * @DateTime 2023-04-01 19:41:43
     *
     * @return int
     */
    public function error():int{
        return $this->error;
    }

    /**
     * 设置返回的数据体
     *
     * @author fdipzone
     * @DateTime 2023-04-01 19:42:25
     *
     * @param mixed $data 返回的数据体
     * @return void
     */
    public function setData($data):void{
        $this->data = $data;
    }

    /**
     * 获取返回的数据体
     *
     * @author fdipzone
     * @DateTime 2023-04-01 19:44:22
     *
     * @return mixed
     */
    public function data(){
        return $this->data;
    }

}