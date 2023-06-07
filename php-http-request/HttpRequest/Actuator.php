<?php
namespace HttpRequest;

/**
 * HttpRequest 请求执行器
 * 用于根据配置执行http请求
 *
 * @author fdipzone
 * @DateTime 2023-06-07 22:56:37
 *
 */
class Actuator
{
    /**
     * 请求连接配置
     *
     * @var \HttpRequest\Config
     */
    private $config;

    /**
     * 初始化，传入配置
     *
     * @author fdipzone
     * @DateTime 2023-06-07 22:57:26
     *
     * @param \HttpRequest\Config $config 请求连接配置
     */
    public function __construct(\HttpRequest\Config $config)
    {
        $this->config = $config;
    }
}