<?php declare(strict_types=1);
namespace Tests\AnnotationReader;

/**
 * 用户
 *
 * @description 用户类
 * @description 用于测试
 * @author fdipzone
 * @DateTime 2024-12-15 19:25:52
 *
 */
class User
{
    /**
     * 姓名
     *
     * @Column name
     * @Tag Name
     * @Tag 中文姓名
     * @var string
     */
    private $name;

    /**
     * 年龄
     *
     * @Column age
     * @Tag Age
     * @var int
     */
    private $age;

    /**
     * 职业
     *
     * @Column profession
     * @Tag Profession
     * @var string
     */
    private $profession;

    /**
     * 初始化
     *
     * @author fdipzone
     * @DateTime 2024-12-15 19:28:30
     *
     * @param string $name 姓名
     * @param int $age 年龄
     * @param string $profession 职业
     */
    public function __construct(string $name, int $age, string $profession)
    {
        $this->name = $name;
        $this->age = $age;
        $this->profession = $profession;
    }

    /**
     * 获取姓名
     *
     * @description 获取姓名
     * @description 获取中文姓名
     * @author fdipzone
     * @DateTime 2024-12-15 19:30:13
     *
     * @return string
     */
    public function name():string
    {
        return $this->name;
    }

    /**
     * 获取年龄
     *
     * @description 获取年龄
     * @author fdipzone
     * @DateTime 2024-12-15 19:30:17
     *
     * @return int
     */
    public function age():int
    {
        return $this->age;
    }

    /**
     * 获取职业
     *
     * @description 获取职业
     * @author fdipzone
     * @DateTime 2024-12-15 19:30:21
     *
     * @return string
     */
    public function profession():string
    {
        return $this->profession;
    }
}