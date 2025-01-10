<?php
namespace Csrf;

/**
 * google recaptcha v2 token类
 *
 * composer lib: https://github.com/google/recaptcha
 * 文档: https://developers.google.com/recaptcha/intro
 *
 * @author fdipzone
 * @DateTime 2025-01-09 18:49:35
 *
 */
class GoogleRecaptchaV2 implements \Csrf\ICsrf
{
    /**
     * google recaptcha 服务密钥
     *
     * @var string
     */
    protected $secret;

    /**
     * 客户端传入的token过期时间（默认30秒）
     *
     * @var string
     */
    protected $timeout;

    /**
     * 初始化
     *
     * @author fdipzone
     * @DateTime 2025-01-09 18:52:47
     *
     * @param \Csrf\Config\GoogleRecaptchaV2Config $config 配置类对象
     */
    public function __construct(\Csrf\Config\GoogleRecaptchaV2Config $config)
    {
        // 检查secret
        if(empty($config->secret()))
        {
            throw new \Csrf\Exception\TokenException('config secret is empty');
        }

        $this->secret = $config->secret();
        $this->timeout = $config->timeout();
    }

    /**
     * 创建 csrf token
     * google recaptcha 不提供 php 生成 token 方法（只提供前端 js 调用 google api 生成 token）
     * 如服务端可使用 \Csrf\InternalCsrf 类实现
     *
     * @author fdipzone
     * @DateTime 2025-01-09 18:53:36
     *
     * @param string $action 请求标识，例如 login, register
     * @return string
     */
    public function generate(string $action):string
    {
        return '';
    }

    /**
     * 验证 csrf token 是否有效
     *
     * @author fdipzone
     * @DateTime 2025-01-09 18:55:00
     *
     * @param string $token csrf token
     * @param string $action 请求标识，例如 login, register
     * @param string $remote_ip 远端 ip
     * @return \Csrf\VerifyResponse
     */
    public function verify(string $token, string $action, string $remote_ip):\Csrf\VerifyResponse
    {
        try
        {
            // 调用 google recaptcha v2 服务执行验证
            $recaptcha_response = $this->googleRecaptchaVerify($token, $action, $remote_ip);

            // 整理返回数据
            $oResponse = new \Csrf\VerifyResponse;

            if($recaptcha_response->isSuccess())
            {
                $oResponse->setSuccess(true);
            }
            else
            {
                $oResponse->setSuccess(false);
                $oResponse->setErrors($recaptcha_response->getErrorCodes());
            }

            return $oResponse;
        }
        catch(\Exception $e)
        {
            throw new \Csrf\Exception\TokenException('google recaptcha v2 call fail');
        }
    }

    /**
     * 调用 google recaptcha v2 服务执行验证
     *
     * @VisibleForTesting
     *
     * @author fdipzone
     * @DateTime 2025-01-09 18:55:47
     *
     * @param string $token csrf token
     * @param string $action 请求标识，例如 login, register
     * @param string $remote_ip 远端 ip
     * @return \ReCaptcha\Response
     */
    protected function googleRecaptchaVerify(string $token, string $action, string $remote_ip):\ReCaptcha\Response
    {
        $recaptcha = new \ReCaptcha\ReCaptcha($this->secret);
        $resp = $recaptcha->setChallengeTimeout($this->timeout)
                          ->verify($token, $remote_ip);
        return $resp;
    }
}