<?php
namespace Csrf\Config;

/**
 * google recaptcha v2 配置类
 *
 * 暂时只定义需要使用的属性，如需要支持更多属性设置可以参考文档
 * https://github.com/google/recaptcha#usage
 *
 * @author fdipzone
 * @DateTime 2025-01-09 19:11:26
 *
 */
class GoogleRecaptchaV2Config implements \Csrf\Config\IConfig
{
    /**
     * google recaptcha服务密钥
     *
     * @var string
     */
    protected $secret = '';

    /**
     * 设置客户端传入的token过期时间（默认30秒）
     *
     * @var int
     */
    protected $timeout = 30;

    /**
     * 初始化，设置 google recaptcha 服务密钥
     *
     * @author fdipzone
     * @DateTime 2025-01-09 19:13:09
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
     * @DateTime 2025-01-09 19:13:33
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
     * @DateTime 2025-01-09 19:14:59
     *
     * @return string
     */
    public function secret():string
    {
        return $this->secret;
    }

    /**
     * 获取客户端传入的token过期时间
     *
     * @author fdipzone
     * @DateTime 2025-01-09 19:15:02
     *
     * @return int
     */
    public function timeout():int
    {
        return $this->timeout;
    }
}