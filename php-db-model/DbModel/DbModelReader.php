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
     * 数据库表 Model 类
     *
     * @var \DbModel\IDbModel
     */
    private $db_model;

    /**
     * 注解阅读器对象
     *
     * @var \AnnotationReader\AnnotationReader
     */
    private $annotation_reader;

    /**
     * 初始化
     *
     * @author fdipzone
     * @DateTime 2024-12-19 18:55:46
     *
     * @param \DbModel\IDbModel $db_model $db_model 数据库 Model 类
     */
    public function __construct(\DbModel\IDbModel $db_model)
    {
        $this->annotation_reader = new \AnnotationReader\AnnotationReader($db_model);
        $this->db_model = $db_model;
    }

    /**
     * 生成创建数据库表的SQL语句
     *
     * @author fdipzone
     * @DateTime 2024-12-19 18:56:07
     *
     * @return string
     */
    public function generateCreateTableSql():string
    {
        // 获取 Model 字段列注解
        $annotation_tags = new \AnnotationReader\AnnotationTags(['@Column']);
        $column_annotations = $this->annotation_reader->propertiesAnnotation($annotation_tags);

        $columns_sql = [];

        // 遍历 Model 字段列注解，创建字段列 SQL 语句
        foreach($column_annotations as $column_annotation)
        {
            // 只获取 @Column 第一个注解，字段列设置不需要有多个注解
            if(isset($column_annotation['@Column'][0]))
            {
                $columns_sql[] = $this->convertToColumnSql($column_annotation['@Column'][0]);
            }
        }

        // SQL 模版
        $sql_template = "CREATE TABLE `%s`.`%s` (".PHP_EOL;
        $sql_template .= "%s".PHP_EOL;
        $sql_template .= "PRIMARY KEY(%s)".PHP_EOL;
        $sql_template .= ") ENGINE=%s %s DEFAULT CHARSET=%s COLLATE=%s COMMENT '%s';";

        $sql = sprintf($sql_template,
            $this->db_model->dbName(),
            $this->db_model->tableName(),
            implode(','.PHP_EOL, $columns_sql).',',
            $this->primaryKeySql($this->db_model->primaryKey()),
            $this->db_model->engine(),
            $this->autoIncrementSql($this->db_model->autoIncrement()),
            $this->db_model->defaultCharset(),
            $this->db_model->collate(),
            $this->db_model->tableComment()
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
    private function primaryKeySql(string $pk):string
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
    private function autoIncrementSql(string $auto_increment):string
    {
        // 不设置自增值
        if($auto_increment==\DbModel\Constants::NO_AUTO_INCREMENT)
        {
            return '';
        }

        return sprintf('AUTO_INCREMENT=%d', $auto_increment);
    }

    /**
     * 根据字段列设置转换为字段列 SQL
     *
     * @author fdipzone
     * @DateTime 2024-12-25 20:13:35
     *
     * @param string $column_setting 字段列设置
     * @return string
     */
    private function convertToColumnSql(string $column_setting):string
    {
        $column_sql_config = [];
        $column_kv_setting = $this->parseColumnSetting($column_setting);

        // name
        if(isset($column_kv_setting['name']) && $column_kv_setting['name']!='')
        {
            $column_sql_config['name'] = '`'.$column_kv_setting['name'].'`';
        }
        else
        {
            throw new \Exception('db model reader: column name cannot be null');
        }

        // type and length 区分需要设置长度的类型与不用设置长度的类型
        if(isset($column_kv_setting['type']) && $column_kv_setting['type']!='' && isset($column_kv_setting['length']) && $column_kv_setting['length']!='')
        {
            $column_sql_config['type'] = $column_kv_setting['type'].'('.$column_kv_setting['length'].')';
        }
        elseif(isset($column_kv_setting['type']) && $column_kv_setting['type']!='')
        {
            $column_sql_config['type'] = $column_kv_setting['type'];
        }
        else
        {
            throw new \Exception('db model reader: column type cannot be null');
        }

        // is unsigned
        if(isset($column_kv_setting['is_unsigned']) && $column_kv_setting['is_unsigned']==1)
        {
            $column_sql_config['is_unsigned'] = 'unsigned';
        }

        // is null
        if(isset($column_kv_setting['is_null']) && $column_kv_setting['is_null']==0)
        {
            $column_sql_config['is_null'] = 'NOT NULL';
        }

        // auto increment
        if(isset($column_kv_setting['auto_increment']) && $column_kv_setting['auto_increment']==1)
        {
            $column_sql_config['auto_increment'] = 'AUTO_INCREMENT';
        }

        // default
        if(isset($column_kv_setting['default']) && $column_kv_setting['default']!=='')
        {
            $column_sql_config['default'] = 'DEFAULT '.$column_kv_setting['default'];
        }

        // comment
        if(isset($column_kv_setting['comment']) && $column_kv_setting['comment']!='')
        {
            $column_sql_config['comment'] = "COMMENT '".$column_kv_setting['comment']."'";
        }

        $column_sql = implode(' ', $column_sql_config);

        return $column_sql;
    }

    /**
     * 解析字段列设置
     * 返回过滤后的设置
     *
     * @author fdipzone
     * @DateTime 2024-12-25 20:23:20
     *
     * @param string $column_setting 字段列设置
     * @return array 设置项 => 设置值
     */
    private function parseColumnSetting(string $column_setting):array
    {
        $column_kv_setting = [];

        $settings = explode(' ', $column_setting);
        if($settings)
        {
            foreach($settings as $setting)
            {
                list($key, $value) = explode('=', $setting);
                $column_kv_setting[$key] = $value;
            }
        }

        return $column_kv_setting;
    }
}