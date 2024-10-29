<?php
namespace Mail;

/**
 * 电子邮件发件人结构体
 *
 * @author fdipzone
 * @DateTime 2024-10-29 11:30:58
 *
 */
class Sender
{
    /**
     * 真实发件人电子邮箱地址
     *
     * @var string
     */
    private $from_email;

    /**
     * 真实发件人名称
     * 为空则使用电子邮箱地址作为发件人名称
     *
     * @var string
     */
    private $from_name;

    /**
     * 发件人电子邮箱地址
     * 收件人看到的电子邮箱地址（Return-Path）
     * 如果没有设置，收件人将看到真实发件人电子邮箱地址
     *
     * @var string
     */
    private $sender_email;

    /**
     * 初始化
     *
     * @author fdipzone
     * @DateTime 2024-10-29 11:46:14
     *
     * @param string $from_email 真实发件人电子邮箱地址
     * @param string $from_name 真实发件人名称
     * @param string $sender_email 发件人电子邮箱地址（Return-Path）
     */
    public function __construct(string $from_email, string $from_name='', string $sender_email='')
    {
        if(empty($from_email))
        {
            throw new \Exception('mailer sender: from email is empty');
        }

        if(!\Mail\Utils::validateEmail($from_email))
        {
            throw new \Exception('mailer sender: from email is invalid');
        }

        if(!empty($sender_email) && !\Mail\Utils::validateEmail($sender_email))
        {
            throw new \Exception('mailer sender: sender email is invalid');
        }

        if(empty($from_name))
        {
            $from_name = $from_email;
        }

        $this->from_email = $from_email;
        $this->from_name = $from_name;
        $this->sender_email = $sender_email;
    }

    /**
     * 获取真实发件人电子邮箱地址
     *
     * @author fdipzone
     * @DateTime 2024-10-29 12:22:55
     *
     * @return string
     */
    public function fromEmail():string
    {
        return $this->from_email;
    }

    /**
     * 获取真实发件人名称
     *
     * @author fdipzone
     * @DateTime 2024-10-29 12:22:59
     *
     * @return string
     */
    public function fromName():string
    {
        return $this->from_name;
    }

    /**
     * 获取发件人电子邮箱地址
     *
     * @author fdipzone
     * @DateTime 2024-10-29 12:23:03
     *
     * @return string
     */
    public function senderEmail():string
    {
        return $this->sender_email;
    }
}