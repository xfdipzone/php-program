<?php
namespace CssUpdater;

/**
 * CSS 文件更新器
 * 用于更新 CSS 文件内的引用文件版本（时间版本），避免访问 CDN 缓存的数据
 * 例如：background:url('images/bg.jpg'); 更新为 background:url('images/bg.jpg?20240914120000')
 *
 * @author fdipzone
 * @DateTime 2024-09-14 16:48:44
 *
 */
class CssUpdater
{
    /**
     * CSS 模版文件存放路径
     *
     * @var string
     */
    private $css_tmpl_path;

    /**
     * CSS 生成文件存放路径
     *
     * @var string
     */
    private $css_path;

    /**
     * 需要处理的引用文件后缀集合
     *
     * @var array
     */
    private $replace_tags = [];

    /**
     * 是否遍历子目录
     *
     * @var bool
     */
    private $recursive = false;

    /**
     * 初始化
     *
     * @author fdipzone
     * @DateTime 2024-09-14 17:28:01
     *
     * @param string $css_tmpl_path CSS 模版文件路径
     * @param string $css_path CSS 生成的文件路径
     * @param array $replace_tags 需要处理的引用文件后缀集合
     * @param boolean $recursive 是否遍历子目录
     */
    public function __construct(string $css_tmpl_path, string $css_path, array $replace_tags, bool $recursive)
    {
        // 检查参数
        if(!is_dir($css_tmpl_path))
        {
            throw new \Exception('css updater: css tmpl path not exists');
        }

        if(empty($css_path))
        {
            throw new \Exception('css updater: css path is empty');
        }

        if(!$replace_tags)
        {
            throw new \Exception('css updater: replace tags is empty');
        }

        $this->css_tmpl_path = $css_tmpl_path;
        $this->css_path = $css_path;
        $this->replace_tags = $replace_tags;
        $this->recursive = $recursive;
    }
}