<?php
namespace HtmlAnalyzer;

/**
 * HTML 文档类
 * 用于保存 HTML URL 与文档内容
 *
 * @author fdipzone
 * @DateTime 2024-11-08 19:11:58
 *
 */
class Document
{
    /**
     * HTML URL
     *
     * @var string
     */
    private $url = '';

    /**
     * HTML 文档内容
     *
     * @var string
     */
    private $doc = '';

    /**
     * 初始化
     * 设置 HTML URL 与文档内容
     *
     * @author fdipzone
     * @DateTime 2024-11-08 19:18:52
     *
     * @param string $url HTML URL
     * @param string $doc HTML 文档内容
     */
    public function __construct(string $url, string $doc)
    {
        if(empty($url))
        {
            throw new \Exception('html analyzer doc: url is empty');
        }

        if(!preg_match('/^(https?:\/\/)?(([a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*\.[a-zA-Z]{2,6}))(?::\d+)?(?:\/[^\s?#]*)?(?:\?[^\s#]*)?(?:#[^\s]*)?$/is', $url))
        {
            throw new \Exception('html analyzer doc: url is invalid');
        }

        if(empty($doc))
        {
            throw new \Exception('html analyzer doc: doc is empty');
        }

        $this->url = $url;
        $this->doc = $doc;
    }

    /**
     * 获取 HTML URL
     *
     * @author fdipzone
     * @DateTime 2024-11-08 19:22:18
     *
     * @return string
     */
    public function url():string
    {
        return $this->url;
    }

    /**
     * 获取 HTML 文档内容
     *
     * @author fdipzone
     * @DateTime 2024-11-08 19:22:29
     *
     * @return string
     */
    public function doc():string
    {
        return $this->doc;
    }
}