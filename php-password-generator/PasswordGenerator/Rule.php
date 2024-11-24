<?php
namespace PasswordGenerator;

/**
 * 密码生成规则
 *
 * @author fdipzone
 * @DateTime 2024-11-20 13:58:12
 *
 */
class Rule
{
    /**
     * 密码长度
     *
     * @var int
     */
    private $length;

    /**
     * 是否包含大写字母
     *
     * @var boolean
     */
    private $has_uppercase = true;

    /**
     * 是否包含小写字母
     *
     * @var boolean
     */
    private $has_lowercase = true;

    /**
     * 是否包含数字
     *
     * @var boolean
     */
    private $has_number = true;

    /**
     * 是否包含特殊字符
     *
     * @var boolean
     */
    private $has_special_character = true;

    /**
     * 可用的特殊字符集合
     * 在 has_special_character 为 true 时有效
     *
     * @var string
     */
    private $special_characters = '!@#$%^&*()_+=-';

    /**
     * 初始化
     * 设置密码长度
     *
     * @author fdipzone
     * @DateTime 2024-11-20 16:17:27
     *
     * @param int $length 密码长度 范围 4 ~ 64
     */
    public function __construct(int $length)
    {
        if($length<4 || $length>64)
        {
            throw new \Exception('password generator rule: password length must be between 4 and 64');
        }

        $this->length = $length;
    }

    /**
     * 获取密码长度
     *
     * @author fdipzone
     * @DateTime 2024-11-20 16:28:36
     *
     * @return int
     */
    public function length():int
    {
        return $this->length;
    }

    /**
     * 设置是否包含大写字母
     *
     * @author fdipzone
     * @DateTime 2024-11-20 16:27:15
     *
     * @param boolean $has_uppercase 是否包含大写字母 true:包含 false:不包含
     * @return void
     */
    public function setHasUppercase(bool $has_uppercase):void
    {
        $this->has_uppercase = $has_uppercase;
    }

    /**
     * 获取是否包含大写字母的设置
     *
     * @author fdipzone
     * @DateTime 2024-11-20 16:27:43
     *
     * @return boolean
     */
    public function hasUppercase():bool
    {
        return $this->has_uppercase;
    }

    /**
     * 设置是否包含小写字母
     *
     * @author fdipzone
     * @DateTime 2024-11-20 16:31:11
     *
     * @param boolean $has_lowercase 是否包含小写字母 true:包含 false:不包含
     * @return void
     */
    public function setHasLowercase(bool $has_lowercase):void
    {
        $this->has_lowercase = $has_lowercase;
    }

    /**
     * 获取是否包含小写字母的设置
     *
     * @author fdipzone
     * @DateTime 2024-11-20 16:31:11
     *
     * @return boolean
     */
    public function hasLowercase():bool
    {
        return $this->has_lowercase;
    }

    /**
     * 设置是否包含数字
     *
     * @author fdipzone
     * @DateTime 2024-11-20 16:33:02
     *
     * @param boolean $has_number 是否包含数字 true:包含 false:不包含
     * @return void
     */
    public function setHasNumber(bool $has_number):void
    {
        $this->has_number = $has_number;
    }

    /**
     * 获取是否包含数字的设置
     *
     * @author fdipzone
     * @DateTime 2024-11-20 16:32:24
     *
     * @return bool
     */
    public function hasNumber():bool
    {
        return $this->has_number;
    }

    /**
     * 设置是否包含特殊字符
     *
     * @author fdipzone
     * @DateTime 2024-11-20 16:34:50
     *
     * @param boolean $has_special_character 是否包含特殊字符 true:包含 false:不包含
     * @return void
     */
    public function setHasSpecialCharacter(bool $has_special_character):void
    {
        $this->has_special_character = $has_special_character;
    }

    /**
     * 获取是否包含特殊字符的设置
     *
     * @author fdipzone
     * @DateTime 2024-11-20 16:35:41
     *
     * @return boolean
     */
    public function hasSpecialCharacter():bool
    {
        return $this->has_special_character;
    }

    /**
     * 设置可用的特殊字符集合
     * 不能包含大小写字母与数字
     *
     * @author fdipzone
     * @DateTime 2024-11-20 16:41:34
     *
     * @param string $special_characters 可用的特殊字符集合
     * @return void
     */
    public function setSpecialCharacters(string $special_characters):void
    {
        // 特殊字符集合为空
        if(empty($special_characters))
        {
            throw new \Exception('password generator rule: special characters is empty');
        }

        // 验证特殊字符是否有效
        if(!$this->validateSpecialCharacters($special_characters))
        {
            throw new \Exception('password generator rule: special characters can not include letter and number');
        }

        $this->special_characters = $special_characters;
    }

    /**
     * 获取可用的特殊字符集合
     *
     * @author fdipzone
     * @DateTime 2024-11-20 16:41:58
     *
     * @return string
     */
    public function specialCharacters():string
    {
        return $this->special_characters;
    }

    /**
     * 判断特殊字符集合是否有效
     * 不能包含大小写字母与数字
     *
     * @author fdipzone
     * @DateTime 2024-11-20 17:00:14
     *
     * @param string $special_characters 特殊字符集合
     * @return boolean
     */
    private function validateSpecialCharacters(string $special_characters):bool
    {
        // 无效的字符集合
        $invalid_characters = 'AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz0123456789';

        // 遍历字符串，检查是否无效
        $length = strlen($special_characters);
        for($i=0; $i<$length; $i++)
        {
            $c = substr($special_characters, $i, 1);
            if(strpos($invalid_characters, $c)!==false)
            {
                return false;
            }
        }

        return true;
    }
}