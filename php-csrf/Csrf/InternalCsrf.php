<?php
namespace Csrf;

/**
 * 内部 csrf token 组件类
 * 用于创建与验证内部 csrf token
 *
 * @author fdipzone
 * @DateTime 2025-01-04 11:55:25
 *
 */
class InternalCsrf implements \Csrf\ICsrf
{
    /**
     * 密钥
     *
     * @var string
     */
    private $secret;

    /**
     * 客户端传入的token过期时间（默认30秒）
     *
     * @var int
     */
    private $timeout;

    /**
     * 初始化
     *
     * @author fdipzone
     * @DateTime 2025-01-04 12:00:44
     *
     * @param \Csrf\Config\InternalCsrfConfig $config 配置类对象
     */
    public function __construct(\Csrf\Config\InternalCsrfConfig $config)
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
     *
     * @author fdipzone
     * @DateTime 2025-01-04 12:01:02
     *
     * @param string $action 请求标识，例如 login, register
     * @return string
     */
    public function generate(string $action):string
    {
        // 创建token结构，随机数+action+当前时间
        $token_arr = array(
            substr(uniqid(), 0, 8),
            $action,
            time(),
        );

        $str = json_encode($token_arr);

        // 加密
        return \Csrf\CryptoUtils::encrypt($str, $this->secret);
    }

    /**
     * 验证 csrf token 是否有效
     *
     * @author fdipzone
     * @DateTime 2025-01-04 12:01:30
     *
     * @param string $token csrf token
     * @param string $action 请求标识，例如 login, register
     * @param string $remote_ip 远端 ip
     * @return \Csrf\VerifyResponse
     */
    public function verify(string $token, string $action, string $remote_ip):\Csrf\VerifyResponse
    {
        // 解密
        $json_str = \Csrf\CryptoUtils::decrypt($token, $this->secret);

        if(!$json_str)
        {
            return $this->response(false, ['csrf token decryption fail']);
        }

        // 转数组
        $token_arr = json_decode($json_str, true);

        if(!is_array($token_arr) || count($token_arr)!=3)
        {
            return $this->response(false, ['csrf token invalid']);
        }

        // 检查action
        if($token_arr[1]!=$action)
        {
            return $this->response(false, ['csrf token action not match']);
        }

        // 检查是否过期
        if(!$this->checkExpire($token_arr[2], $this->timeout))
        {
            return $this->response(false, ['csrf token expire']);
        }

        return $this->response(true);
    }

    /**
     * 检查 token 是否过期
     * 根据token生成时间+过期时间，与当前时间对比，如大于当前时间表示未过期，否则过期
     *
     * @author fdipzone
     * @DateTime 2025-01-04 12:02:44
     *
     * @param int $token_time token生成时间
     * @param int $timeout 过期时间（秒）
     * @return boolean
     */
    protected function checkExpire(int $token_time, int $timeout):bool
    {
        return (($token_time + $timeout) > time());
    }

    /**
     * 输出验证结果
     *
     * @author fdipzone
     * @DateTime 2025-01-04 12:03:25
     *
     * @param boolean $success 是否成功 true/false
     * @param array $errors 错误信息集合
     * @return \Csrf\VerifyResponse
     */
    private function response(bool $success, array $errors=[]):\Csrf\VerifyResponse
    {
        $oResponse = new \Csrf\VerifyResponse;
        $oResponse->setSuccess($success);
        $oResponse->setErrors($errors);
        return $oResponse;
    }
}