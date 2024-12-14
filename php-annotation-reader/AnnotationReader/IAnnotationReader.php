<?php
namespace AnnotationReader;

/**
 * 注解阅读器接口
 * 定义注解阅读器必须实现的方法
 *
 * @author fdipzone
 * @DateTime 2024-12-14 16:34:23
 *
 */
interface IAnnotationReader
{
    /**
     * 获取类文件注解
     *
     * @author fdipzone
     * @DateTime 2024-12-14 16:34:23
     *
     * @param \AnnotationReader\AnnotationTags $annotation_tags 需要解析的注解标签集合
     * @return array
     */
    public function classAnnotation(\AnnotationReader\AnnotationTags $annotation_tags):array;

    /**
     * 获取类所有属性注解
     *
     * @author fdipzone
     * @DateTime 2024-12-14 16:34:38
     *
     * @param \AnnotationReader\AnnotationTags $annotation_tags 需要解析的注解标签集合
     * @return array property => annotations
     */
    public function propertiesAnnotation(\AnnotationReader\AnnotationTags $annotation_tags):array;

    /**
     * 获取类所有方法注解
     *
     * @author fdipzone
     * @DateTime 2024-12-14 16:34:47
     *
     * @param \AnnotationReader\AnnotationTags $annotation_tags 需要解析的注解标签集合
     * @return array method => annotations
     */
    public function methodsAnnotation(\AnnotationReader\AnnotationTags $annotation_tags):array;
}