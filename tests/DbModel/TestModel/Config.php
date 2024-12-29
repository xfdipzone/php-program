<?php declare(strict_types=1);
namespace Tests\DbModel\TestModel;

/**
 * 配置表
 *
 * @author fdipzone
 * @DateTime 2024-12-29 12:05:31
 *
 */
class Config extends \DbModel\AbstractDbModel implements \DbModel\IDbModel
{
    // 数据库名
    protected $db_name = 'test_common';

    // 数据表名
    protected $table_name = 'config';

    // 数据表注释
    protected $table_comment = '配置表';

    /**
     * 配置id
     *
     * @Column name=id type=int length=11 is_null=0 is_unsigned=1 auto_increment=1 comment=配置id
     * @var int
     */
    private $id;

    /**
     * 配置内容
     *
     * @Column name=content type=text is_null=0 comment=配置内容
     * @var string
     */
    private $content;
}