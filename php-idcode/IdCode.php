<?php
/**
 * php 根据自增id创建唯一编号类
 * 
 * 格式 [prefix]-[multiple letters]-[multiple numbers]
 * 例: 3999 => F-D-999
 *
 * @author fdipzone
 * @DateTime 2023-07-13 20:11:48
 *
 */
class IdCode
{
    /**
     * 根据自增id创建唯一编号
     *
     * @author fdipzone
     * @DateTime 2023-07-13 20:12:36
     *
     * @param int $id 自增id
     * @param int $num_length 数字部分最大位数
     * @param string $prefix 前缀
     * @return string
     */
    public static function create(int $id, int $num_length, string $prefix):string
    {
        // 基数
        $base = pow(10, $num_length);

        // 生成字母部分
        $division = (int)($id/$base);
        $word = '';

        while($division)
        {
            $tmp = fmod($division, 26); // 只使用26个大写字母
            $tmp = chr($tmp + 65);      // 转为字母
            $word .= $tmp;
            $division = floor($division/26);
        }

        if($word=='')
        {
            $word = chr(65);
        }

        // 生成数字部分
        $mod = $id % $base;
        $digital = str_pad($mod, $num_length, 0, STR_PAD_LEFT);

        $code = sprintf('%s-%s-%s', $prefix, $word, $digital);
        return $code;
    }

}