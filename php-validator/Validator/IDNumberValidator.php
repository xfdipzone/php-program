<?php
/**
 * 证件号码验证类
 *
 * @author fdipzone
 * @DateTime 2024-08-02 22:12:28
 *
 */
class IDNumberValidator
{
    /**
     * 验证中国身份证号码（18位）
     *
     * @author fdipzone
     * @DateTime 2024-08-02 22:25:05
     *
     * @param string $id_card 中国身份证号码（18位）
     * @return boolean
     */
    public static function IDCard(string $id_card):bool
    {
        return true;
    }
}