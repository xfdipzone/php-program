<?php
namespace AnnotationReader;

/**
 * 注解阅读器
 *
 * @author fdipzone
 * @DateTime 2024-12-14 16:06:48
 *
 */
class AnnotationReader implements \AnnotationReader\IAnnotationReader
{
    /**
     * 反射类对象
     *
     * @var \ReflectionClass
     */
    private $ref_class = null;

    /**
     * 初始化
     * 创建反射类对象
     *
     * @author fdipzone
     * @DateTime 2024-12-14 16:06:48
     *
     * @param object|string $class 类对象或类名称
     */
    public function __construct($class)
    {
        try
        {
            $this->ref_class = new \ReflectionClass($class);
        }
        catch(\Throwable $e)
        {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * 获取类文件注解
     *
     * @author fdipzone
     * @DateTime 2024-12-14 16:34:23
     *
     * @param \AnnotationReader\AnnotationTags $annotation_tags 需要解析的注解标签集合
     * @return array
     */
    public function classAnnotation(\AnnotationReader\AnnotationTags $annotation_tags): array
    {
        return $this->parseAnnotationTags($this->ref_class->getDocComment(), $annotation_tags);
    }

    /**
     * 获取类所有属性注解
     *
     * @author fdipzone
     * @DateTime 2024-12-14 16:34:38
     *
     * @param \AnnotationReader\AnnotationTags $annotation_tags 需要解析的注解标签集合
     * @return array property => annotations
     */
    public function propertiesAnnotation(\AnnotationReader\AnnotationTags $annotation_tags): array
    {
        $properties_doc_comment = [];

        $properties = $this->ref_class->getProperties();
        if($properties)
        {
            foreach($properties as $property)
            {
                $properties_doc_comment[$property->name] = $this->parseAnnotationTags($property->getDocComment(), $annotation_tags);
            }
        }

        return $properties_doc_comment;
    }

    /**
     * 获取类所有方法注解
     *
     * @author fdipzone
     * @DateTime 2024-12-14 16:34:47
     *
     * @param \AnnotationReader\AnnotationTags $annotation_tags 需要解析的注解标签集合
     * @return array method => annotations
     */
    public function methodsAnnotation(\AnnotationReader\AnnotationTags $annotation_tags): array
    {
        $methods_doc_comment = [];

        $methods = $this->ref_class->getMethods();
        if($methods)
        {
            foreach($methods as $method)
            {
                $methods_doc_comment[$method->name] = $this->parseAnnotationTags($method->getDocComment(), $annotation_tags);
            }
        }

        return $methods_doc_comment;
    }

    /**
     * 解析注解标签
     *
     * @author fdipzone
     * @DateTime 2024-12-14 16:48:11
     *
     * @param string $doc_comment 注释内容
     * @param \AnnotationReader\AnnotationTags $annotation_tags 需要解析的注解标签集合
     * @return array
     */
    private function parseAnnotationTags(string $doc_comment, \AnnotationReader\AnnotationTags $annotation_tags):array
    {
        $annotations = [];

        $pattern = '/('.implode('|', $annotation_tags->tags()).')\s(.*)(\s|\r\n|\r|\n|$)/';
        preg_match_all($pattern, $doc_comment, $matches, PREG_SET_ORDER);

        if($matches)
        {
            foreach($matches as $match)
            {
                $tag = $match[1];
                $value = $match[2];
                $annotations[$tag][] = $value;
            }
        }

        return $annotations;
    }
}