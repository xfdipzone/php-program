<?php
namespace Validator;

/**
 * 证件号码验证类
 * 提供多种证件号码验证方法
 *
 * 支持的验证方法：
 * 验证中国身份证号码（18位）
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
    public static function idCard(string $id_card):bool
    {
        // 检查身份证号码长度
        if(strlen($id_card)!=18)
        {
            return false;
        }

        // 取出本体码
        $base_code = substr($id_card, 0, 17);

        // 本体码必须是数字
        if(!is_numeric($base_code))
        {
            return false;
        }

        // 取出校验码
        $verify_code = substr($id_card, 17, 1);

        // 加权因子
        $factor = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);

        // 校验码对应值
        $verify_code_list = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');

        // 根据前17位计算校验码
        $total = 0;
        for($i=0; $i<17; $i++)
        {
            $total += substr($base_code, $i, 1)*$factor[$i];
        }

        // 取模
        $mod = $total % 11;

        // 比较校验码
        if($verify_code == $verify_code_list[$mod])
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}