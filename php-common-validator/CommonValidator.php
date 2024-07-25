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
}