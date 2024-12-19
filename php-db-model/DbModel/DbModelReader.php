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
        $annotation_tags = new \AnnotationReader\AnnotationTags(['@Column']);
        $column_annotations = $this->annotation_reader->propertiesAnnotation($annotation_tags);

        return '';
    }
}