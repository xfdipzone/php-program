<?php
/**
 * 通用验证类
 * 提供常用的验证方法，例如是否为空，长度验证，是否数字，是否中文等
 *
 * @author fdipzone
 * @DateTime 2024-07-25 21:51:14
 *
 */
class CommonValidator
{
    /**
     * 判断字符串是否为空
     *
     * @author fdipzone
     * @DateTime 2024-07-25 21:57:17
     *
     * @param string $val 字符串
     * @param boolean $ignore_zero true: '0' 属于空，false: '0' 不属于空
     * @return boolean
     */
    public static function empty(string $val, bool $ignore_zero=true):bool
    {
        if(!$ignore_zero)
        {
            // 0 不属于空
            return empty($val) && $val!=='0';
        }

        // 0 属于空
        return empty($val);
    }

    /**
     * 判断字符串长度是否在范围内
     * 字符串会使用 utf-8 编码计算长度
     *
     * @author fdipzone
     * @DateTime 2024-07-25 22:01:57
     *
     * @param string $val 字符串
     * @param int $min_length 范围长度下限
     * @param int $max_length 范围长度上限
     * @return boolean
     */
    public static function length(string $val, int $min_length=0, int $max_length=999):bool
    {
        if($min_length > $max_length)
        {
            throw new \Exception('common validator: min length > max length invalid');
        }

        $length = mb_strlen($val, 'utf-8');
        return $length >= $min_length && $length <= $max_length? true : false;
    }

    /**
     * 判断数据是否数字
     * 支持浮点数与负数判断
     *
     * @author fdipzone
     * @DateTime 2024-07-26 13:15:50
     *
     * @param mixed $val 数据
     * @param boolean $allow_float 是否允许浮点数 true: 允许 false: 不允许
     * @param boolean $allow_signed 是否允许负数 true: 允许 false: 不允许
     * @return boolean
     */
    public static function number($val, bool $allow_float=false, bool $allow_signed=false):bool
    {
        if($allow_signed)
        {
            return $allow_float? is_numeric($val) : preg_match('/^-?([0-9])+$/', $val);
        }
        else
        {
            return $allow_float? preg_match('/^([0-9])+([\.|,]([0-9])*)?$/', $val) : preg_match('/^([0-9])+$/', $val);
        }
    }

    /**
     * 判断是否http/https地址
     *
     * @author fdipzone
     * @DateTime 2024-07-26 19:23:23
     *
     * @param string $val 字符串
     * @return boolean
     */
    public static function http(string $val):bool
    {
        return preg_match('/^(https?:\/\/)?(([a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*\.[a-zA-Z]{2,6}))(?::\d+)?(?:\/[^\s?#]*)?(?:\?[^\s#]*)?(?:#[^\s]*)?$/is', $val);
    }

    /**
     * 判断是否域名格式
     *
     * @author fdipzone
     * @DateTime 2024-07-26 19:24:36
     *
     * @param string $val
     * @return boolean
     */
    public static function domain(string $val):bool
    {
        $pattern = '/^([a-z0-9]+([a-z0-9-]*(?:[a-z0-9]+))?\.)?[a-z0-9]+([a-z0-9-]*(?:[a-z0-9]+))?(\.us|\.tv|\.org\.cn|\.org|\.net\.cn|\.net|\.mobi|\.me|\.la|\.info|\.hk|\.gov\.cn|\.edu|\.com\.cn|\.com|\.co\.jp|\.co|\.cn|\.cc|\.biz)$/i';
        return strpos($val, '--') === false &&
        preg_match($pattern, $val) ? true : false;
    }

    /**
     * 判断字符串是否英文
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
     * 判断字符串是否中文
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
     * 判断字符串是否泰文
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
     * 判断字符串是否越南文
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