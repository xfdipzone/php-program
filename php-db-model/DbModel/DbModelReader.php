<?php
namespace DbModel;

/**
 * 数据库表 Model 文件注解阅读器
 * 根据 Model 类注解，生成创建表 SQL 语句
 *
 * @author fdipzone
 * @DateTime 2024-12-19 18:55:05
 *
 */
class DbModelReader
{
    /**
     * 生成创建数据库表的SQL语句
     *
     * @author fdipzone
     * @DateTime 2024-12-19 18:56:07
     *
     * @param \DbModel\IDbModel $db_model 数据库 Model 类
     * @return string
     */
    public static function generateCreateTableSql(\DbModel\IDbModel $db_model):string
    {
        // 创建注解阅读器
        $annotation_reader = new \AnnotationReader\AnnotationReader($db_model);

        // 获取 Model 字段列注解
        $annotation_tags = new \AnnotationReader\AnnotationTags(['@Column']);
        $column_annotations = $annotation_reader->propertiesAnnotation($annotation_tags);

        $columns_sql = [];

        // 遍历 Model 字段列注解，创建字段列 SQL 语句
        foreach($column_annotations as $column_annotation)
        {
            // 只获取 @Column 第一个注解，字段列设置不需要有多个注解
            if(isset($column_annotation['@Column'][0]))
            {
                $columns_sql[] = \DbModel\ColumnParser::convertToColumnSql($column_annotation['@Column'][0]);
            }
        }

        // SQL 模版
        $sql_template = "CREATE TABLE `%s`.`%s` (".PHP_EOL;
        $sql_template .= "%s".PHP_EOL;
        $sql_template .= "PRIMARY KEY(%s)".PHP_EOL;
        $sql_template .= ") ENGINE=%s %s DEFAULT CHARSET=%s COLLATE=%s COMMENT '%s';";

        $sql = sprintf($sql_template,
            $db_model->dbName(),
            $db_model->tableName(),
            implode(','.PHP_EOL, $columns_sql).',',
            self::primaryKeySql($db_model->primaryKey()),
            $db_model->engine(),
            self::autoIncrementSql($db_model->autoIncrement()),
            $db_model->defaultCharset(),
            $db_model->collate(),
            $db_model->tableComment()
        );

        return $sql;
    }

    /**
     * 主键 SQL
     *
     * @author fdipzone
     * @DateTime 2024-12-25 20:13:16
     *
     * @param string $pk 主键字段，如有多个使用 "," 分割
     * @return string
     */
    private static function primaryKeySql(string $pk):string
    {
        $fields = explode(',', $pk);
        return '`'.implode('`,`', $fields).'`';
    }

    /**
     * auto increment SQL
     *
     * @author fdipzone
     * @DateTime 2024-12-26 16:43:04
     *
     * @param string $auto_increment 自增设置
     * @return string
     */
    private static function autoIncrementSql(string $auto_increment):string
    {
        // 不设置自增值
        if($auto_increment==\DbModel\Constants::NO_AUTO_INCREMENT)
        {
            return '';
        }

        return sprintf('AUTO_INCREMENT=%d', $auto_increment);
    }
}