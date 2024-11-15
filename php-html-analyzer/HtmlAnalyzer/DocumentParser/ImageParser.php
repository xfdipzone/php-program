<?php
namespace HtmlAnalyzer\DocumentParser;

/**
 * 图片解析器
 * 解析文档，获取文档中所有图片
 * 过滤重复的数据
 *
 * @author fdipzone
 * @DateTime 2024-11-15 17:12:12
 *
 */
class ImageParser implements \HtmlAnalyzer\DocumentParser\IParser
{
    /**
     * 解析文档
     * 返回匹配的数据
     *
     * @author fdipzone
     * @DateTime 2024-11-15 17:17:05
     *
     * @param \HtmlAnalyzer\Document $document HTML 文档对象
     * @return array
     */
    public static function parse(\HtmlAnalyzer\Document $document):array
    {
        $pattern = '/<img[^>]*src=["\']([^"\']+)["\'][^>]*>/i';
        preg_match_all($pattern, $document->doc(), $matches);
        return isset($matches[1])? array_unique($matches[1]) : [];
    }
}