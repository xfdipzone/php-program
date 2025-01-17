<?php
namespace DbModel;

/**
 * 数据库表 Model 接口
 *
 * @author fdipzone
 * @DateTime 2024-12-19 18:51:59
 *
 */
interface IDbModel
{
    /**
     * 获取数据库名称
     *
     * @author fdipzone
     * @DateTime 2024-12-19 18:51:59
     *
     * @return string
     */
    public function dbName():string;

    /**
     * 获取数据表名称
     *
     * @author fdipzone
     * @DateTime 2024-12-19 18:51:59
     *
     * @return string
     */
    public function tableName():string;

    /**
     * 获取数据表注释
     *
     * @author fdipzone
     * @DateTime 2024-12-19 18:51:59
     *
     * @return string
     */
    public function tableComment():string;

    /**
     * 获取数据库引擎
     *
     * @author fdipzone
     * @DateTime 2024-12-19 18:51:59
     *
     * @return string
     */
    public function engine():string;

    /**
     * 获取默认字符集
     *
     * @author fdipzone
     * @DateTime 2024-12-19 18:51:59
     *
     * @return string
     */
    public function defaultCharset():string;

    /**
     * 获取校对规则
     *
     * @author fdipzone
     * @DateTime 2024-12-19 18:51:59
     *
     * @return string
     */
    public function collate():string;

    /**
     * 获取主键字段
     *
     * @author fdipzone
     * @DateTime 2024-12-21 17:58:39
     *
     * @return string
     */
    public function primaryKey():string;

    /**
     * 获取自增主键初始值
     *
     * @author fdipzone
     * @DateTime 2024-12-21 17:58:43
     *
     * @return int
     */
    public function autoIncrement():int;

    /**
     * 获取数据表索引设置
     *
     * @author fdipzone
     * @DateTime 2024-12-28 16:58:17
     *
     * @return string
     */
    public function tableIndex():string;
}