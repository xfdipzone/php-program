<?php
namespace Mail;

/**
 * 电子邮件发送器
 * 用于发送电子邮件，支持批量发送及发送附件
 * 使用 SMTP（Simple Mail Transfer Protocol）协议
 *
 * @author fdipzone
 * @DateTime 2024-10-23 19:09:27
 *
 */
class Mailer
{
    /**
     * 电子邮件服务器配置
     *
     * @var \Mail\ServerConfig
     */
    private $server_config;

    /**
     * 初始化
     * 设置电子邮件服务器配置
     *
     * @author terry
     * @DateTime 2024-10-26 16:18:49
     *
     * @param \Mail\ServerConfig $server_config 电子邮件服务器配置
     */
    public function __construct(\Mail\ServerConfig $server_config)
    {
        $this->server_config = $server_config;
    }
}