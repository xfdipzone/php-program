<?php
namespace HtmlAnalyzer;

/**
 * HTML 分析器
 * 用于分析 HTML 内容，根据配置获取内容中所需数据，例如：url, email, image 等
 *
 * @author fdipzone
 * @DateTime 2024-11-08 17:07:56
 *
 */
class Analyzer
{
    /**
     * HTML 文档对象
     *
     * @var \HtmlAnalyzer\Document
     */
    private $document;

    /**
     * 初始化
     * 设置 HTML 文档对象
     *
     * @author fdipzone
     * @DateTime 2024-11-08 19:29:30
     *
     * @param \HtmlAnalyzer\Document $html_doc HTML 文档对象
     */
    public function __construct(\HtmlAnalyzer\Document $document)
    {
        $this->document = $document;
    }

    /**
     * 获取 HTML 文档中所有 email
     * 过滤重复的数据
     *
     * @author fdipzone
     * @DateTime 2024-11-13 23:22:17
     *
     * @return array
     */
    public function emails():array
    {
        $pattern = '/([\w\-\.]+@[\w\-\.]+(\.\w+))/';
        preg_match_all($pattern, $this->document->doc(), $matches);
        return isset($matches[1])? array_unique($matches[1]) : [];
    }

    /**
     * 获取 HTML 文档中所有 url
     * 过滤重复的数据
     *
     * @author fdipzone
     * @DateTime 2024-11-13 23:24:16
     *
     * @return array
     */
    public function urls():array
    {
        $pattern = '/<a.*?href="((http(s)?:\/\/).*?)".*?/si';
        preg_match_all($pattern, $this->document->doc(), $matches);
        return isset($matches[1])? array_unique($matches[1]) : [];
    }

    /**
     * 获取 HTML 文档中所有 image
     * 过滤重复的数据
     *
     * @author fdipzone
     * @DateTime 2024-11-13 23:24:54
     *
     * @return array
     */
    public function images():array
    {
        $pattern = '/<img[^>]*src=["\']([^"\']+)["\'][^>]*>/i';
        preg_match_all($pattern, $this->document->doc(), $matches);
        return isset($matches[1])? array_unique($matches[1]) : [];
    }
}