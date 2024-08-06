<?php
namespace SensitiveWordFilter;

/**
 * 敏感词过滤器接口
 * 定义敏感词过滤器实现类需要实现的方法
 *
 * @author fdipzone
 * @DateTime 2024-08-06 19:05:54
 *
 */
interface ISensitiveWordFilter
{
    /**
     * 敏感词过滤
     * 将数据内容中的敏感词替换为指定字符，返回过滤敏感词后的数据内容
     *
     * @author fdipzone
     * @DateTime 2024-08-06 19:06:59
     *
     * @param string $content 数据内容
     * @return string
     */
    public function filter(string $content):string;
}