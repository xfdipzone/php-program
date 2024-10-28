<?php
namespace Mail;

/**
 * 电子邮件收件人结构体
 *
 * @author fdipzone
 * @DateTime 2024-10-27 19:11:25
 *
 */
class EmailRecipient
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
            throw new \Exception('mailer email recipient: email is empty');
        }

        if(!$this->validateEmail($email))
        {
            throw new \Exception('mailer email recipient: email is invalid');
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

    /**
     * 验证电子邮箱地址是否合法
     *
     * @author fdipzone
     * @DateTime 2024-10-28 10:22:22
     *
     * @param string $email 电子邮箱地址
     * @return boolean
     */
    private function validateEmail(string $email):bool
    {
        return preg_match("/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/", $email);
    }
}