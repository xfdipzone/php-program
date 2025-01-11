<?php
namespace Csrf\Config;

/**
 * google recaptcha v3 配置类
 *
 * 暂时只定义需要使用的属性，如需要支持更多属性设置可以参考文档
 * https://github.com/google/recaptcha#usage
 *
 * @author fdipzone
 * @DateTime 2025-01-11 16:42:41
 *
 */
class GoogleRecaptchaV3Config implements \Csrf\Config\IConfig
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
     * 分数阈值(浮点类型），范围 0~1，计算返回分数>=阈值表示通过，否则不通过（默认0.5）
     *
     * @var float
     */
    protected $score_threshold = 0.5;

    /**
     * 初始化，设置 google recaptcha 服务密钥
     *
     * @author fdipzone
     * @DateTime 2025-01-11 16:43:36
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
     * @DateTime 2025-01-11 16:44:33
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
     * 设置分数阈值，范围0~1
     *
     * @author fdipzone
     * @DateTime 2025-01-11 16:46:05
     *
     * @param float $score_threshold 分数阈值
     * @return void
     */
    public function setScoreThreshold(float $score_threshold):void
    {
        if($score_threshold<0.01 || $score_threshold>1)
        {
            throw new \Csrf\Exception\ConfigException('score threshold must be between 0.01 and 1');
        }
        $this->score_threshold = round($score_threshold, 2); // 保留两位小数
    }

    /**
     * 获取密钥
     *
     * @author fdipzone
     * @DateTime 2025-01-11 16:44:33
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
     * @DateTime 2025-01-11 16:44:33
     *
     * @return int
     */
    public function timeout():int
    {
        return $this->timeout;
    }

    /**
     * 获取分数阈值
     *
     * @author fdipzone
     * @DateTime 2025-01-11 16:46:37
     *
     * @return float
     */
    public function scoreThreshold():float
    {
        return $this->score_threshold;
    }
}