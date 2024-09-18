<?php
namespace CssManager;

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
     * 不需要包含 "."，例如 jpg, gif, png
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
     * 日志文件
     *
     * @var string
     */
    private $log_file = '';

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
    public function __construct(string $css_tmpl_path, string $css_path, array $replace_tags, bool $recursive=false)
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

    /**
     * 设置日志文件
     *
     * @author fdipzone
     * @DateTime 2024-09-15 22:28:17
     *
     * @param string $log_file 日志文件
     * @return void
     */
    public function setLogFile(string $log_file):void
    {
        if(empty($log_file))
        {
            throw new \Exception('css updater: log file is empty');
        }

        $this->log_file = $log_file;
    }

    /**
     * 获取日志文件路径
     *
     * @author fdipzone
     * @DateTime 2024-09-16 23:13:13
     *
     * @return string
     */
    public function logFile():string
    {
        return $this->log_file;
    }

    /**
     * 执行更新
     *
     * @author fdipzone
     * @DateTime 2024-09-15 22:32:44
     *
     * @return int 成功更新的文件数量
     */
    public function update():int
    {
        // 成功更新的文件数量
        $success_num = 0;

        // 遍历 css 模版目录
        $tmpl_files = [];
        \CssManager\Utils::traversing($this->css_tmpl_path, $tmpl_files, $this->recursive);

        foreach($tmpl_files as $tmpl_file)
        {
            // 检查文件后缀是否 css
            if(!\CssManager\Utils::checkExtension($tmpl_file, ['css']))
            {
                continue;
            }

            // 计算目标 css 文件路径
            $dest_file = str_replace($this->css_tmpl_path, $this->css_path, $tmpl_file);

            // 创建 css 文件
            $is_created = $this->create($tmpl_file, $dest_file);

            if($is_created)
            {
                $success_num++;
            }

            // 记录日志
            if($this->logFile())
            {
                $log_content = sprintf('%s convert to %s %s', $tmpl_file, $dest_file, $is_created==true? 'success' : 'fail');
                \CssManager\Utils::log($this->logFile(), $log_content);
            }
        }

        return $success_num;
    }

    /**
     * 创建目标 css 文件
     *
     * @author fdipzone
     * @DateTime 2024-09-15 23:00:20
     *
     * @param string $source_file 模版文件
     * @param string $dest_file 目标文件
     * @return boolean
     */
    private function create(string $source_file, string $dest_file):bool
    {
        $css_content = file_get_contents($source_file);

        // 加入时间版本
        $version = date('YmdHis');

        // 正则替换模版
        $pattern = sprintf('/url\(([\'"])(.*?\.(%s))\\1\)/', implode('|', $this->replace_tags));
        $replacement = 'url($1$2?'.$version.'$1)';
        $css_content = preg_replace($pattern, $replacement, $css_content);

        // 创建文件目录
        \CssManager\Utils::createDirs(dirname($dest_file));

        // 写入文件
        return (bool)(file_put_contents($dest_file, $css_content));
    }
}