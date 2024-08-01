<?php
namespace Validator;

/**
 * 语言验证类
 * 提供多种语言验证方法，检查输入的文字是否对应的语言
 *
 * 支持验证的语言：
 * 英文
 * 中文
 * 泰文
 * 越南文
 *
 * @author fdipzone
 * @DateTime 2024-08-01 13:25:45
 *
 */
class LanguageValidator
{
    /**
     * 验证字符串是否英文
     *
     * @author fdipzone
     * @DateTime 2024-07-26 17:07:46
     *
     * @param string $val 字符串
     * @return boolean
     */
    public static function isEnglish(string $val):bool
    {
        return preg_match('/^[A-Za-z]+$/', $val);
    }

    /**
     * 验证字符串是否中文
     *
     * @author fdipzone
     * @DateTime 2024-07-26 17:08:01
     *
     * @param string $val 字符串
     * @return boolean
     */
    public static function isChinese(string $val):bool
    {
        return preg_match('/[\x{4e00}-\x{9fa5}]/u', $val);
    }

    /**
     * 验证字符串是否泰文
     *
     * @author fdipzone
     * @DateTime 2024-07-26 17:08:11
     *
     * @param string $val 字符串
     * @return boolean
     */
    public static function isThai(string $val):bool
    {
        return preg_match('/^(?=.*?[\p{Thai}])[\p{Thai} ]+$/u', $val);
    }

    /**
     * 验证字符串是否越南文
     * 越南文字符集中包含英文字符，因此不能区分越南文与英文
     * 传入字符串为英文时，会返回 true
     *
     *
     * @author fdipzone
     * @DateTime 2024-07-26 17:08:22
     *
     * @param string $val 字符串
     * @return boolean
     */
    public static function isVietnamese(string $val):bool
    {
        return preg_match('/[\p{Script=Latin}]+/u', $val);
    }
}