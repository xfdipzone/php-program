<?php
namespace AnnotationReader;

/**
 * 定义需要解析的注解标签集合
 *
 * @author fdipzone
 * @DateTime 2024-12-14 16:06:48
 *
 */
class AnnotationTags
{
    /**
     * 需要解析的注解标签集合
     *
     * @var array
     */
    private $annotation_tags = [];

    /**
     * 设置需要解析的注解标签
     * 注解标签规则
     * - 必须使用 @ 开头的字符串，且只能有一个@
     * - 包含A-Z, a-z, 0-9，且@后第一个位不能是数字
     * - 大小写敏感
     * 重复的标签只作为一个标签
     *
     * @author fdipzone
     * @DateTime 2024-12-14 16:09:31
     *
     * @param array $annotation_tags 注解标签集合
     */
    public function __construct(array $annotation_tags)
    {
        if(empty($annotation_tags))
        {
            throw new \Exception('annotation reader: annotation tags is empty');
        }

        if(!$this->validateTags($annotation_tags))
        {
            throw new \Exception('annotation reader: annotation tags is invalid');
        }

        $this->annotation_tags = array_unique($annotation_tags);
    }

    /**
     * 获取注解标签集合
     *
     * @author fdipzone
     * @DateTime 2024-12-14 16:32:01
     *
     * @return array
     */
    public function tags():array
    {
        return $this->annotation_tags;
    }

    /**
     * 检查注解标签格式是否正确
     *
     * @author fdipzone
     * @DateTime 2024-12-14 16:29:29
     *
     * @param array $annotation_tags 注解标签集合
     * @return boolean
     */
    private function validateTags(array $annotation_tags):bool
    {
        $pattern = '/^@[a-zA-Z][a-zA-Z0-9]*$/';

        foreach($annotation_tags as $annotation_tag)
        {
            if(preg_match($pattern, $annotation_tag)!==1)
            {
                return false;
            }
        }

        return true;
    }
}