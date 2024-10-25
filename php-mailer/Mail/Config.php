<?php
namespace Mail;

/**
 * 电子邮件发送器配置文件
 *
 * @author fdipzone
 * @DateTime 2024-10-25 10:51:43
 *
 */
class Config
{
    /**
     * SMTP 服务器地址
     *
     * @var string
     */
    private $smtp_host = '';

    /**
     * SMTP 服务器端口
     *
     * @var int
     */
    private $smtp_port = 465;

    /**
     * SMTP 加密方式
     *
     * @var string
     */
    private $smtp_secure = 'ssl';

    /**
     * 是否打开 SMTP 认证
     *
     * @var boolean
     */
    private $smtp_auth = true;

    /**
     * SMTP 服务用户名
     *
     * @var string
     */
    private $smtp_username = '';

    /**
     * SMTP 服务密码
     *
     * @var string
     */
    private $smtp_password = '';

    /**
     * 是否启用 debug
     *
     * @var boolean
     */
    private $smtp_debug = false;

    /**
     * 初始化
     *
     * @author fdipzone
     * @DateTime 2024-10-25 11:08:10
     *
     */
    public function __construct(string $smtp_host, string $smtp_username, string $smtp_password)
    {
        if(empty($smtp_host))
        {
            throw new \Exception('mailer config: smtp host is empty');
        }

        if(empty($smtp_username))
        {
            throw new \Exception('mailer config: smtp username is empty');
        }

        if(empty($smtp_password))
        {
            throw new \Exception('mailer config: smtp password is empty');
        }

        $this->smtp_host = $smtp_host;
        $this->smtp_username = $smtp_username;
        $this->smtp_password = $smtp_password;
    }

    /**
     * 获取 SMTP 服务器地址
     *
     * @author fdipzone
     * @DateTime 2024-10-25 11:20:49
     *
     * @return string
     */
    public function smtpHost():string
    {
        return $this->smtp_host;
    }

    /**
     * 获取 SMTP 服务用户名
     *
     * @author fdipzone
     * @DateTime 2024-10-25 11:21:05
     *
     * @return string
     */
    public function smtpUsername():string
    {
        return $this->smtp_username;
    }

    /**
     * 获取 SMTP 服务密码
     *
     * @author fdipzone
     * @DateTime 2024-10-25 11:21:17
     *
     * @return string
     */
    public function smtpPassword():string
    {
        return $this->smtp_password;
    }

    /**
     * 设置 SMTP 服务器端口
     *
     * @author fdipzone
     * @DateTime 2024-10-25 11:25:50
     *
     * @param int $port SMTP 服务器端口
     * @return void
     */
    public function setSmtpPort(int $port):void
    {
        if($port<0 || $port>65535)
        {
            throw new \Exception('mailer config: port must be between 0 and 65535');
        }

        $this->smtp_port = $port;
    }

    /**
     * 获取 SMTP 服务器端口
     *
     * @author fdipzone
     * @DateTime 2024-10-25 11:25:45
     *
     * @return int
     */
    public function smtpPort():int
    {
        return $this->smtp_port;
    }

    /**
     * 设置 SMTP 加密方式
     *
     * @author fdipzone
     * @DateTime 2024-10-25 11:29:21
     *
     * @param string $smtp_secure SMTP 加密方式
     * @return void
     */
    public function setSmtpSecure(string $smtp_secure):void
    {
        if(empty($smtp_secure))
        {
            throw new \Exception('mailer config: smtp secure is empty');
        }

        $this->smtp_secure = $smtp_secure;
    }

    /**
     * 获取 SMTP 加密方式
     *
     * @author fdipzone
     * @DateTime 2024-10-25 11:30:54
     *
     * @return string
     */
    public function smtpSecure():string
    {
        return $this->smtp_secure;
    }

    /**
     * 设置开启/关闭 SMTP 认证
     *
     * @author fdipzone
     * @DateTime 2024-10-25 11:31:59
     *
     * @param boolean $smtp_auth 是否开启认证 true:开启 false:关闭
     * @return void
     */
    public function setSmtpAuth(bool $smtp_auth):void
    {
        $this->smtp_auth = $smtp_auth;
    }

    /**
     * 获取 SMTP 认证开启/关闭状态
     *
     * @author fdipzone
     * @DateTime 2024-10-25 11:33:02
     *
     * @return boolean
     */
    public function smtpAuth():bool
    {
        return $this->smtp_auth;
    }

    /**
     * 设置开启/关闭 SMTP debug
     *
     * @author fdipzone
     * @DateTime 2024-10-25 11:33:52
     *
     * @param boolean $smtp_debug 是否开启 debug true: 开启 false: 关闭
     * @return void
     */
    public function setSmtpDebug(bool $smtp_debug):void
    {
        $this->smtp_debug = $smtp_debug;
    }

    /**
     * 获取SMTP debug 开启/关闭状态
     *
     * @author fdipzone
     * @DateTime 2024-10-25 11:34:39
     *
     * @return boolean
     */
    public function smtpDebug():bool
    {
        return $this->smtp_debug;
    }
}