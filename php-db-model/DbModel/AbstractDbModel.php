<?php
namespace DbModel;

/**
 * 数据库表 Model 父类
 *
 * @author fdipzone
 * @DateTime 2024-12-21 17:41:44
 *
 */
abstract class AbstractDbModel
{
    /**
     * 默认数据库名称
     *
     * @var string
     */
    protected $db_name = '';

    /**
     * 默认数据表名称
     *
     * @var string
     */
    protected $table_name = '';

    /**
     * 默认数据表注释
     *
     * @var string
     */
    protected $table_comment = '';

    /**
     * 数据库引擎
     *
     * @var string
     */
    protected $engine = 'InnoDB';

    /**
     * 默认字符集
     *
     * @var string
     */
    protected $default_charset = 'utf8mb4';

    /**
     * 校对规则
     *
     * @var string
     */
    protected $collate = 'utf8mb4_unicode_ci';

    /**
     * 默认主键字段
     *
     * @var string
     */
    protected $pk = 'id';

    /**
     * 默认自增主键初始值
     *
     * @var int
     */
    protected $auto_increment = 1;

    /**
     * 获取数据库名称
     *
     * @author fdipzone
     * @DateTime 2024-12-21 17:56:32
     *
     * @return string
     */
    public function dbName():string
    {
        return $this->db_name;
    }

    /**
     * 获取数据表名称
     *
     * @author fdipzone
     * @DateTime 2024-12-21 17:56:42
     *
     * @return string
     */
    public function tableName():string
    {
        return $this->table_name;
    }

    /**
     * 获取数据表注释
     *
     * @author fdipzone
     * @DateTime 2024-12-21 17:56:54
     *
     * @return string
     */
    public function tableComment():string
    {
        return $this->table_comment;
    }

    /**
     * 获取数据库引擎
     *
     * @author fdipzone
     * @DateTime 2024-12-21 17:57:03
     *
     * @return string
     */
    public function engine():string
    {
        return $this->engine;
    }

    /**
     * 获取默认字符集
     *
     * @author fdipzone
     * @DateTime 2024-12-21 17:57:14
     *
     * @return string
     */
    public function defaultCharset():string
    {
        return $this->default_charset;
    }

    /**
     * 获取校对规则
     *
     * @author fdipzone
     * @DateTime 2024-12-21 17:57:25
     *
     * @return string
     */
    public function collate():string
    {
        return $this->collate;
    }

    /**
     * 获取主键字段
     *
     * @author fdipzone
     * @DateTime 2024-12-21 17:59:53
     *
     * @return string
     */
    public function primaryKey():string
    {
        return $this->pk;
    }

    /**
     * 获取自增主键初始值
     *
     * @author fdipzone
     * @DateTime 2024-12-21 18:00:09
     *
     * @return int
     */
    public function autoIncrement():int
    {
        return $this->auto_increment;
    }
}