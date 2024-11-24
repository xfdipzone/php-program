<?php
namespace PasswordGenerator;

/**
 * 密码生成器
 * 用于按配置生成密码，例如必须包含数字，大小写字母，特殊字符等
 *
 * @author fdipzone
 * @DateTime 2024-11-20 13:56:33
 *
 */
class Generator
{
    /**
     * 生成密码
     *
     * @author fdipzone
     * @DateTime 2024-11-20 14:00:32
     *
     * @param \PasswordGenerator\Rule $rule 密码生成规则
     * @param int $num 密码生成数量 范围：1 ~ 100
     * @return array
     */
    public static function generate(\PasswordGenerator\Rule $rule, int $num=1):array
    {
        // 生成的密码数量检查
        if($num<1 || $num>100)
        {
            throw new \Exception('password generator: the number of passwords generate must be between 1 and 100');
        }

        // 没有设置任何规则选项
        if(!$rule->hasUppercase() && !$rule->hasLowercase() && !$rule->hasNumber() && !$rule->hasSpecialCharacter())
        {
            throw new \Exception('password generator: rule not setting any options');
        }

        // 设置了需要特殊字符，但是没有设置可用的特殊字符集合
        if($rule->hasSpecialCharacter() && $rule->specialCharacters()=='')
        {
            throw new \Exception('password generator: rule required special character but not setting special characters');
        }

        // 循环创建密码
        $passwords = [];

        for($i=0; $i<$num; $i++)
        {
            $password = self::create($rule);
            $passwords[] = $password;
        }

        return $passwords;
    }

    /**
     * 根据规则生成密码
     *
     * @author fdipzone
     * @DateTime 2024-11-24 17:17:03
     *
     * @param \PasswordGenerator\Rule $rule 密码生成规则
     * @return string
     */
    private static function create(\PasswordGenerator\Rule $rule):string
    {
        $upper_letter = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $lower_letter = 'abcdefghijklmnopqrstuvwxyz';
        $number = '1234567890';
        $special_characters = $rule->specialCharacters();

        // 生成的密码
        $password = '';

        // 可以使用的字符集合
        $strings = '';

        // 必须包含大写字母
        if($rule->hasUppercase())
        {
            // 随机选择一个大写字母加入密码
            $password .= substr($upper_letter, mt_rand(0, strlen($upper_letter)-1), 1);

            // 将大写字母加入可用字符集合
            $strings .= $upper_letter;
        }

        // 必须包含小写字母
        if($rule->hasLowercase())
        {
            // 随机选择一个小写字母加入密码
            $password .= substr($lower_letter, mt_rand(0, strlen($lower_letter)-1), 1);

            // 将小写字母加入可用字符集合
            $strings .= $lower_letter;
        }

        // 必须包含数字
        if($rule->hasNumber())
        {
            // 随机选择一个数字加入密码
            $password .= substr($number, mt_rand(0, strlen($number)-1), 1);

            // 将数字加入可用字符集合
            $strings .= $number;
        }

        // 必须包含特殊字符
        if($rule->hasSpecialCharacter())
        {
            // 随机选择一个特殊字符加入密码
            $password .= substr($special_characters, mt_rand(0, strlen($special_characters)-1), 1);

            // 将可用特殊字符集合加入可用字符集合
            $strings .= $special_characters;
        }

        // 获取密码剩余的长度
        while($remain_length=$rule->length()-strlen($password)>0)
        {
            // 随机打乱可用字符集合
            $pool = str_shuffle($strings);
            $password .= substr($pool, 0, $remain_length);
        }

        // 随机打乱密码顺序
        $password = str_shuffle($password);

        return $password;
    }
}