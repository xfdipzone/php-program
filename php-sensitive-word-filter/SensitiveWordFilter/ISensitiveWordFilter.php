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
     * 检查数据内容中是否包含敏感词
     *
     * @author fdipzone
     * @DateTime 2024-08-07 20:03:31
     *
     * @param string $content 数据内容
     * @return boolean true: 包含敏感词, false: 不包含敏感词
     */
    public function isContain(string $content):bool;

    /**
     * 敏感词过滤
     * 将数据内容中的敏感词替换为指定字符，返回过滤敏感词后的数据内容
     *
     * @author fdipzone
     * @DateTime 2024-08-06 19:06:59
     *
     * @param string $content 数据内容
     * @param string $replacement 敏感词替换字符
     * @return string
     */
    public function filter(string $content, string $replacement='*'):string;
}