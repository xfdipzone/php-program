<?php
namespace Csrf;

/**
 * csrf token 组件接口
 * 定义 csrf token 组件需要实现的方法
 *
 * @author fdipzone
 * @DateTime 2025-01-04 11:17:41
 *
 */
interface ICsrf
{
    /**
     * 创建 csrf token
     *
     * @author fdipzone
     * @DateTime 2025-01-04 11:23:09
     *
     * @param string $action 请求标识，例如 login, register
     * @return string
     */
    public function generate(string $action):string;

    /**
     * 验证 csrf token 是否有效
     *
     * @author fdipzone
     * @DateTime 2025-01-04 11:24:19
     *
     * @param string $token csrf token
     * @param string $action 请求标识，例如 login, register
     * @param string $remote_ip 远端 ip
     * @return \Csrf\VerifyResponse
     */
    public function verify(string $token, string $action, string $remote_ip):\Csrf\VerifyResponse;
}