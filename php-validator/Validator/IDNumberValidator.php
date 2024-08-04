<?php
namespace Validator;

/**
 * 证件号码验证类
 * 提供多种证件号码验证方法
 *
 * 支持的验证方法：
 * 验证中国身份证号码（18位）
 * 验证中国车牌号码（包括新能源车牌）
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
     * 中国身份证号码（18位）结构
     * 身份证号码是特征组合码，由17位数字本体码和一位校验码组成。
     * 排列顺序从左至右依此为：六位数字地址码，八位数字出生日期码，三位数字顺序码和一位数字校验码。
     *
     * 地址码（前六位数）
     * 表示编码对象常住户口所在县（市、旗、区）的行政区划代码，按GB/T2260的规定执行。
     *
     * 出生日期码（第七位至十四位）
     * 表示编码对象出生的年、月、日，按GB/T7408的规定执行，年、月、日代码之间不用分隔符。
     *
     * 顺序码（第十五位至十七位）
     * 表示在同一地址码所标识的区域范围，对同年、同月、同日出生的人编定的顺序号，顺序码奇数分配给男性，偶数分配给女性。
     *
     * 校验码（第十八位数）
     *
     *
     * 验证流程
     * 1.十七位数字本体码加权求和公式
     * S = SUM(Ai * Wi), i=0, ... , 16, 先对前17位数字的权求和。
     * Ai：表示第i位置上的身份证号码数字值
     * Wi：表示第i位置上的加权因子
     * 0~16 位置的加权因子列表（7 9 10 5 8 4 2 1 6 3 7 9 10 5 8 4 2）
     *
     * 2.计算模
     * Y = mod(S, 11)
     *
     * 3.通过模得到对应的校验码
     * Y：0 1 2 3 4 5 6 7 8 9 10
     * 模对应的校验码：1 0 X 9 8 7 6 5 4 3 2
     *
     * 4.通过身份证最后一位与模得到的校验码比对
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
        $checksum = substr($id_card, 17, 1);

        // 加权因子
        $factor = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);

        // 校验码对应值
        $checksum_list = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');

        // 根据前17位计算校验码
        $total = 0;
        for($i=0; $i<17; $i++)
        {
            $total += substr($base_code, $i, 1)*$factor[$i];
        }

        // 取模
        $mod = $total % 11;

        // 比较校验码
        if($checksum == $checksum_list[$mod])
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * 验证中国车牌号码（包括新能源车牌）
     *
     * @author fdipzone
     * @DateTime 2024-08-04 19:43:58
     *
     * @param string $license_plate 中国车牌号码
     * @return boolean
     */
    public static function licensePlateNumber(string $license_plate):bool
    {
        $pattern = '/^(([京津沪渝冀豫云辽黑湘皖鲁新苏浙赣鄂桂甘晋蒙陕吉闽贵粤青藏川宁琼使领][A-Z](([0-9]{5}[DF])|([DF]([A-HJ-NP-Z0-9])[0-9]{4})))|([京津沪渝冀豫云辽黑湘皖鲁新苏浙赣鄂桂甘晋蒙陕吉闽贵粤青藏川宁琼使领][A-Z][A-HJ-NP-Z0-9]{4}[A-HJ-NP-Z0-9挂学警港澳使领]))$/';
        return preg_match($pattern, $license_plate);
    }
}