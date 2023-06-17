<?php
namespace HttpRequest\Connect;

/**
 * HttpRequest 连接配置类
 *
 * @author fdipzone
 * @DateTime 2023-06-07 22:34:55
 *
 */
class Config
{
    /**
     * 请求的host/ip地址
     *
     * @var string
     */
    private $host = '';

    /**
     * 请求的端口号
     *
     * @var int
     */
    private $port = 0;

    /**
     * 请求超时时间（秒）
     *
     * @var int
     */
    private $timeout = 15;

    /**
     * 初始化，传入host/ip地址, port
     *
     * @author fdipzone
     * @DateTime 2023-06-07 22:39:18
     *
     * @param string $host 请求的host/ip地址
     * @param int $port 请求的端口号
     */
    public function __construct(string $host, int $port)
    {
        if(empty($host))
        {
            throw new \Exception('host parameter is empty');
        }

        if(empty($port))
        {
            throw new \Exception('port parameter is empty');
        }

        $this->host = $host;
        $this->port = $port;
    }

    /**
     * 获取请求的host/ip地址
     *
     * @author fdipzone
     * @DateTime 2023-06-07 22:47:16
     *
     * @return string
     */
    public function host():string
    {
        return $this->host;
    }

    /**
     * 获取请求的端口
     *
     * @author fdipzone
     * @DateTime 2023-06-07 22:47:24
     *
     * @return int
     */
    public function port():int
    {
        return $this->port;
    }

    /**
     * 设置请求超时时间（秒）
     *
     * @author fdipzone
     * @DateTime 2023-06-07 22:41:46
     *
     * @param int $timeout 请求超时时间（秒）
     * @return void
     */
    public function setTimeout(int $timeout):void
    {
        if(empty($timeout) || $timeout<=0)
        {
            throw new \Exception('timeout parameter error');
        }

        $this->timeout = $timeout;
    }

    /**
     * 获取请求超时时间（秒）
     *
     * @author fdipzone
     * @DateTime 2023-06-07 22:44:02
     *
     * @return int
     */
    public function timeout():int
    {
        return $this->timeout;
    }
}