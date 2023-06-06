<?php
/**
 * php实现的HttpRequest请求类，支持GET, POST, Multipart/form-data方式
 *
 * @author fdipzone
 * @DateTime 2023-06-06 23:33:21
 *
 */
class HttpRequest
{
    /**
     * http连接
     *
     * @var resource
     */
    private $fp = null;

    /**
     * 创建http连接
     *
     * @author fdipzone
     * @DateTime 2023-06-06 23:36:29
     *
     * @param string $ip ip地址
     * @param int $port  端口
     * @param int $timeout 连接超时时间（秒）
     * @return boolean
     */
    private function connect(string $ip, int $port, int $timeout):bool
    {
        $err_no = '';
        $err_msg = '';

        $this->fp = fsockopen($ip, $port, $err_no, $err_msg, $timeout);

        return $this->fp? true : false;
    }

    /**
     * 断开http连接
     *
     * @author fdipzone
     * @DateTime 2023-06-06 23:36:53
     *
     * @return void
     */
    private function disconnect():void
    {
        if($this->fp!=null)
        {
            fclose($this->fp);
            $this->fp = null;
        }
    }
}