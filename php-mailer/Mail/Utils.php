<?php
namespace Mail;

/**
 * 通用方法集合
 *
 * @author fdipzone
 * @DateTime 2024-10-29 11:50:45
 *
 */
class Utils
{
    /**
     * 验证电子邮箱地址是否合法
     *
     * @author fdipzone
     * @DateTime 2024-10-29 11:51:30
     *
     * @param string $email
     * @return boolean
     */
    public static function validateEmail(string $email):bool
    {
        return preg_match("/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/", $email);
    }
}