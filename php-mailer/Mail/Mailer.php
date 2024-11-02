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
     * 发件人
     *
     * @var \Mail\Sender
     */
    private $sender;

    /**
     * 收件人集合
     *
     * @var array [] \Mail\Recipient
     */
    private $recipients;

    /**
     * 抄送收件人集合
     *
     * @var array [] \Mail\Recipient
     */
    private $ccRecipients;

    /**
     * 密件抄送收件人集合
     *
     * @var array [] \Mail\Recipient
     */
    private $bccRecipients;

    /**
     * 附件集合
     *
     * @var array [] \Mail\Attachment
     */
    private $attachments;

    /**
     * 是否使用 html 格式发送
     *
     * @var boolean
     */
    private $is_html = true;

    /**
     * 初始化
     * 设置电子邮件服务器配置
     *
     * @author fdipzone
     * @DateTime 2024-10-26 16:18:49
     *
     * @param \Mail\ServerConfig $server_config 电子邮件服务器配置
     */
    public function __construct(\Mail\ServerConfig $server_config)
    {
        $this->server_config = $server_config;
    }

    /**
     * 设置发件人
     *
     * @author fdipzone
     * @DateTime 2024-10-30 18:40:47
     *
     * @param \Mail\Sender $sender 发件人对象
     * @return void
     */
    public function setSender(\Mail\Sender $sender):void
    {
        $this->sender = $sender;
    }

    /**
     * 获取发件人
     *
     * @author fdipzone
     * @DateTime 2024-10-30 19:21:04
     *
     * @return \Mail\Sender
     */
    public function sender():\Mail\Sender
    {
        return $this->sender;
    }

    /**
     * 添加收件人
     *
     * @author fdipzone
     * @DateTime 2024-10-30 18:51:20
     *
     * @param \Mail\Recipient $recipient 收件人
     * @return void
     */
    public function addRecipient(\Mail\Recipient $recipient):void
    {
        $this->recipients[$recipient->email()] = $recipient;
    }

    /**
     * 获取收件人集合
     *
     * @author fdipzone
     * @DateTime 2024-10-30 19:22:07
     *
     * @return array [email] => \Mail\Recipient
     */
    public function recipients():array
    {
        return $this->recipients;
    }

    /**
     * 添加抄送收件人
     *
     * @author fdipzone
     * @DateTime 2024-10-30 19:03:18
     *
     * @param \Mail\Recipient $recipient 抄送收件人
     * @return void
     */
    public function addCcRecipient(\Mail\Recipient $recipient):void
    {
        $this->ccRecipients[$recipient->email()] = $recipient;
    }

    /**
     * 获取抄送收件人集合
     *
     * @author fdipzone
     * @DateTime 2024-10-30 19:23:00
     *
     * @return array [email] => \Mail\Recipient
     */
    public function ccRecipients():array
    {
        return $this->ccRecipients;
    }

    /**
     * 添加密件抄送收件人
     *
     * @author fdipzone
     * @DateTime 2024-10-30 19:03:18
     *
     * @param \Mail\Recipient $recipient 密件抄送收件人
     * @return void
     */
    public function addBccRecipient(\Mail\Recipient $recipient):void
    {
        $this->bccRecipients[$recipient->email()] = $recipient;
    }

    /**
     * 获取密件抄送收件人集合
     *
     * @author fdipzone
     * @DateTime 2024-10-30 19:23:39
     *
     * @return array [email] => \Mail\Recipient
     */
    public function bccRecipients():array
    {
        return $this->bccRecipients;
    }

    /**
     * 添加附件
     *
     * @author fdipzone
     * @DateTime 2024-10-30 18:53:09
     *
     * @param \Mail\Attachment $attachment 附件
     * @return void
     */
    public function addAttachment(\Mail\Attachment $attachment):void
    {
        $this->attachments[$attachment->file()] = $attachment;
    }

    /**
     * 获取附件集合
     *
     * @author fdipzone
     * @DateTime 2024-10-30 19:25:05
     *
     * @return array [file] => \Mail\attachment
     */
    public function attachments():array
    {
        return $this->attachments;
    }

    /**
     * 设置是否使用 html 格式发送
     *
     * @author fdipzone
     * @DateTime 2024-11-02 18:07:11
     *
     * @param boolean $is_html 是否使用 html 格式 true: 是 false: 否
     * @return void
     */
    public function setIsHtml(bool $is_html):void
    {
        $this->is_html = $is_html;
    }

    /**
     * 获取是否使用 html 格式发送
     *
     * @author fdipzone
     * @DateTime 2024-11-02 18:09:34
     *
     * @return boolean
     */
    public function isHtml():bool
    {
        return $this->is_html;
    }

    /**
     * 发送电子邮件
     *
     * @author fdipzone
     * @DateTime 2024-11-02 18:18:03
     *
     * @param string $subject 邮件标题
     * @param string $body 邮件内容
     * @return boolean
     */
    public function send(string $subject, string $body):bool
    {
        try
        {
            // 检查邮件标题
            if(empty($subject))
            {
                throw new \Exception('mailer: email subject is empty');
            }

            // 检查邮件内容
            if(empty($body))
            {
                throw new \Exception('mailer: email body is empty');
            }

            // 检查发件人
            if(!$this->sender())
            {
                throw new \Exception('mailer: sender not setup');
            }

            // 检查收件人
            if(!$this->recipients())
            {
                throw new \Exception('mailer: recipient not setup');
            }

            // Core PHP Mailer
            $mailer = new \Mail\Core\PHPMailer;
            $mailer->SMTPDebug = $this->server_config->smtpDebug();
            $mailer->IsSMTP();
            $mailer->Host = $this->server_config->smtpHost();
            $mailer->Port = $this->server_config->smtpPort();
            $mailer->SMTPSecure = $this->server_config->smtpSecure();
            $mailer->SMTPAuth = $this->server_config->smtpAuth();
            $mailer->Username = $this->server_config->smtpUsername();
            $mailer->Password = $this->server_config->smtpPassword();

            // 标题，内容，发送格式
            $mailer->Subject = $subject;
            $mailer->Body = $body;
            $mailer->IsHTML($this->isHtml());

            // 发件人
            $mailer->From = $this->sender->fromEmail();
            $mailer->FromName = $this->sender->fromName();
            $mailer->Sender = $this->sender->senderEmail();

            // 收件人
            $recipients = $this->recipients();
            foreach($recipients as $recipient)
            {
                $mailer->AddAddress($recipient->email(), $recipient->name());
            }

            // 抄送收件人
            $cc_recipients = $this->ccRecipients();
            if(count($cc_recipients)>0)
            {
                foreach($cc_recipients as $cc_recipient)
                {
                    $mailer->AddCC($cc_recipient->email(), $cc_recipient->name());
                }
            }

            // 密件抄送收件人
            $bcc_recipients = $this->bccRecipients();
            if(count($bcc_recipients)>0)
            {
                foreach($bcc_recipients as $bcc_recipient)
                {
                    $mailer->AddBCC($bcc_recipient->email(), $bcc_recipient->name());
                }
            }

            // 附件
            $attachments = $this->attachments();
            if(count($attachments))
            {
                foreach($attachments as $attachment)
                {
                    $mailer->AddAttachment($attachment->file(), $attachment->name());
                }
            }

            // 执行发送
            return $mailer->Send();
        }
        catch(\Throwable $e)
        {
            throw new \Exception($e->getMessage());
        }
    }
}