<?php
namespace HttpRequest\Connect;

/**
 * HttpRequest连接器，用于创建与断开http连接
 *
 * @author fdipzone
 * @DateTime 2023-06-06 23:33:21
 *
 */
class Connector
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
     * @param string $host host/ip地址
     * @param int $port  端口
     * @param int $timeout 连接超时时间（秒）
     * @return resource
     */
    public function connect(string $host, int $port, int $timeout)
    {
        $err_no = 0;
        $err_msg = '';

        try
        {
            if($this->fp==null)
            {
                $this->fp = fsockopen($host, $port, $err_no, $err_msg, $timeout);

                // 创建连接失败
                if($err_no)
                {
                    throw new \Exception('err_no:'.$err_no.' err_msg:'.$err_msg);
                }
            }
        }
        catch(\Throwable $e)
        {
            throw new \Exception($e->getMessage());
        }

        return $this->fp;
    }

    /**
     * 断开http连接
     *
     * @author fdipzone
     * @DateTime 2023-06-06 23:36:53
     *
     * @return void
     */
    public function disconnect():void
    {
        if($this->fp!=null)
        {
            try
            {
                fclose($this->fp);
                $this->fp = null;
            }
            catch(\Throwable $e)
            {
                throw new \Exception($e->getMessage());
            }
        }
    }
}