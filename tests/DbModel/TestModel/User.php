<?php declare(strict_types=1);
namespace Tests\DbModel\TestModel;

/**
 * 用户表
 *
 * @author fdipzone
 * @DateTime 2024-12-26 15:29:49
 *
 */
class User extends \DbModel\AbstractDbModel implements \DbModel\IDbModel
{
    // 数据库名
    protected $db_name = 'test_user';

    // 数据表名
    protected $table_name = 'user';

    // 数据表注释
    protected $table_comment = '用户表';

    // 自增值
    protected $auto_increment = 1001;

    /**
     * 用户id
     *
     * @Column name=id type=int length=11 is_null=0 is_unsigned=1 auto_increment=1 comment=用户id
     * @var int
     */
    private $id;

    /**
     * 电话
     *
     * @Column name=phone type=varchar length=11 is_null=0 comment=电话号码
     * @var string
     */
    private $phone;

    /**
     * 姓名
     *
     * @Column name=name type=varchar length=11 is_null=0 default='' comment=姓名
     * @var string
     */
    private $name;

    /**
     * 年龄
     *
     * @Column name=age type=tinyint length=3 is_null=0 is_unsigned=1 default=0 comment=年龄
     * @var int
     */
    private $age;

    /**
     * 备注
     *
     * @Column name=remark type=text is_null=0 comment=备注
     * @var string
     */
    private $remark;

    /**
     * 获取数据表索引设置
     *
     * @author fdipzone
     * @DateTime 2024-12-28 17:14:32
     *
     * @return string
     */
    public function tableIndex(): string
    {
        $index = [
            'UNIQUE INDEX `phone` (`phone` ASC)',
            'INDEX `age` (`age` ASC)',
        ];

        return implode(','.PHP_EOL, $index);
    }
}