<?php
namespace Mail;

/**
 * 电子邮件收件人结构体
 * 用于电子邮件收件人，抄送收件人，密件抄送收件人，回复人
 *
 * @author fdipzone
 * @DateTime 2024-10-27 19:11:25
 *
 */
class Recipient
{
    /**
     * 电子邮箱地址
     *
     * @var string
     */
    private $email;

    /**
     * 收件人名称
     * 为空则使用电子邮箱地址作为收件人名称
     *
     * @var string
     */
    private $name;

    /**
     * 初始化
     *
     * @author fdipzone
     * @DateTime 2024-10-28 10:19:42
     *
     * @param string $email 电子邮箱地址
     * @param string $name 收件人名称，为空则使用电子邮箱地址作为收件人名称
     */
    public function __construct(string $email, string $name='')
    {
        if(empty($email))
        {
            throw new \Exception('mailer recipient: email is empty');
        }

        if(!\Mail\Utils::validateEmail($email))
        {
            throw new \Exception('mailer recipient: email is invalid');
        }

        // 收件人名称为空使用电子邮箱地址作为收件人名称
        if(empty($name))
        {
            $name = $email;
        }

        $this->email = $email;
        $this->name = $name;
    }

    /**
     * 获取收件人电子邮箱地址
     *
     * @author fdipzone
     * @DateTime 2024-10-28 10:26:56
     *
     * @return string
     */
    public function email():string
    {
        return $this->email;
    }

    /**
     * 获取收件人名称
     *
     * @author fdipzone
     * @DateTime 2024-10-28 10:27:07
     *
     * @return string
     */
    public function name():string
    {
        return $this->name;
    }
}