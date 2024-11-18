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
     * @param \HtmlAnalyzer\Document $document HTML 文档对象
     */
    public function __construct(\HtmlAnalyzer\Document $document)
    {
        $this->document = $document;
    }

    /**
     * 根据类型解析文档，获取文档中指定类型的数据
     *
     * @author fdipzone
     * @DateTime 2024-11-15 18:06:12
     *
     * @param string $type 资源类型，在 \HtmlAnalyzer\Type 中定义
     * @return array
     */
    public function getResource(string $type):array
    {
        if(!isset(\HtmlAnalyzer\Type::$map[$type]))
        {
            throw new \Exception(sprintf('html analyzer: type %s not exists', $type));
        }

        $class = \HtmlAnalyzer\Type::$map[$type];
        return $class::parse($this->document);
    }
}