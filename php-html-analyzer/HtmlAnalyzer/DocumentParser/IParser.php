<?php
namespace HtmlAnalyzer\DocumentParser;

/**
 * 文档解析器接口
 * 定义文档解析器需要实现的方法
 *
 * @author fdipzone
 * @DateTime 2024-11-15 17:09:02
 *
 */
interface IParser
{
    /**
     * 解析文档
     * 返回匹配的数据
     *
     * @author fdipzone
     * @DateTime 2024-11-15 17:17:05
     *
     * @param \HtmlAnalyzer\Document $document
     * @return array
     */
    public static function parse(\HtmlAnalyzer\Document $document):array;
}