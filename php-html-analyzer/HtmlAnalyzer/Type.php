<?php
namespace HtmlAnalyzer;

/**
 * 定义支持的文档解析器类型
 *
 * @author fdipzone
 * @DateTime 2024-11-15 17:21:55
 *
 */
class Type
{
    // 解析文档中的 Email
    const EMAIL = 'email';

    // 解析文档中的 URL
    const URL = 'url';

    // 解析文档中的图片
    const IMAGE = 'image';

    // 解析文档中的 CSS
    const CSS = 'css';

    // 类型与实现类对应关系
    public static $map = [
        self::EMAIL => '\HtmlAnalyzer\DocumentParser\EmailParser',
        self::URL => '\HtmlAnalyzer\DocumentParser\UrlParser',
        self::IMAGE => '\HtmlAnalyzer\DocumentParser\ImageParser',
        self::CSS => '\HtmlAnalyzer\DocumentParser\CssParser',
    ];
}