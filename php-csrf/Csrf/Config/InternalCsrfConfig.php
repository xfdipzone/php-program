<?php
namespace Csrf\Config;

/**
 * internal csrf token 组件配置类
 *
 * @author fdipzone
 * @DateTime 2025-01-04 11:43:20
 *
 */
class InternalCsrfConfig implements \Csrf\Config\IConfig
{
    // 密钥
    protected $secret = '';

    // 设置客户端传入的token过期时间（默认30秒）
    protected $timeout = 30;

    /**
     * 初始化，设置密钥
     *
     * @author fdipzone
     * @DateTime 2025-01-04 11:43:20
     *
     * @param string $secret 密钥
     */
    public function __construct(string $secret)
    {
        if(empty($secret))
        {
            throw new \Csrf\Exception\ConfigException('secret is empty');
        }
        $this->secret = $secret;
    }

    /**
     * 设置客户端传入的token过期时间
     *
     * 只允许设置1-300秒范围
     *
     * @author fdipzone
     * @DateTime 2025-01-04 11:43:20
     *
     * @param int $timeout 超时时间
     * @return void
     */
    public function setTimeout(int $timeout):void
    {
        if($timeout<1 || $timeout>300)
        {
            throw new \Csrf\Exception\ConfigException('timeout must be between 1 and 300 seconds');
        }
        $this->timeout = $timeout;
    }

    /**
     * 获取密钥
     *
     * @author fdipzone
     * @DateTime 2025-01-04 11:43:20
     *
     * @return string
     */
    public function getSecret():string
    {
        return $this->secret;
    }

    /**
     * 获取客户端传入的token过期时间
     *
     * @author fdipzone
     * @DateTime 2025-01-04 11:43:20
     *
     * @return int
     */
    public function getTimeout():int
    {
        return $this->timeout;
    }
}