<?php
namespace DbModel;

/**
 * 字段列解析器
 * 解析字段列设置，创建字段列 SQL 语句
 *
 * @author fdipzone
 * @DateTime 2024-12-27 13:10:15
 *
 */
class ColumnParser
{
    /**
     * 根据字段列设置转换为字段列 SQL
     *
     * @author fdipzone
     * @DateTime 2024-12-27 13:10:15
     *
     * @param string $column_setting 字段列设置
     * @return string
     */
    public static function convertToColumnSql(string $column_setting):string
    {
        $column_sql_config = [];

        // 将 column 设置转为 key=value 格式
        $column_kv_setting = self::parseColumnSetting($column_setting);

        // name
        if(isset($column_kv_setting['name']) && $column_kv_setting['name']!='')
        {
            $column_sql_config['name'] = '`'.$column_kv_setting['name'].'`';
        }
        else
        {
            throw new \Exception('db model column parser: column name cannot be null');
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
            throw new \Exception('db model column parser: column type cannot be null');
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
     * @DateTime 2024-12-27 13:10:15
     *
     * @param string $column_setting 字段列设置
     * @return array 设置项 => 设置值
     */
    private static function parseColumnSetting(string $column_setting):array
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