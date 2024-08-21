<?php
namespace SensitiveWordFilter;

/**
 * 支持白名单保护的敏感词过滤器（装饰器）
 * 对默认敏感词过滤器增加白名单保护功能
 * 白名单中的词，不会被当作敏感词过滤
 *
 * @author fdipzone
 * @DateTime 2024-08-20 18:55:49
 *
 */
class WhiteListProtectFilter implements \SensitiveWordFilter\ISensitiveWordFilter
{
    /**
     * 敏感词过滤器
     *
     * @var \SensitiveWordFilter\ISensitiveWordFilter
     */
    private $sensitive_word_filter;

    /**
     * 敏感词白名单 KV 结构
     * key=>value key:词 value:true
     * 用于过滤重复敏感词与加速追加处理
     *
     * @var array
     */
    private $kv_white_list_words = [];

    /**
     * 敏感词白名单
     *
     * @var array
     */
    private $white_list_words = [];

    /**
     * 初始化
     * 传入敏感词过滤器
     *
     * @author fdipzone
     * @DateTime 2024-08-20 19:02:06
     *
     * @param \SensitiveWordFilter\ISensitiveWordFilter $filter 敏感词过滤器
     */
    public function __construct(\SensitiveWordFilter\ISensitiveWordFilter $sensitive_word_filter)
    {
        $this->sensitive_word_filter = $sensitive_word_filter;
    }

    /**
     * 设置敏感词白名单
     * 此方法可多次调用，追加敏感词列表
     *
     * @author fdipzone
     * @DateTime 2024-08-20 19:23:46
     *
     * @param array $white_list_words 敏感词白名单
     * @return void
     */
    public function setWhiteListWords(array $white_list_words):void
    {
        if(!$white_list_words)
        {
            throw new \Exception('white list protect filter: white list words is empty');
        }

        $new_kv_white_list_words = array_fill_keys($white_list_words, true);
        $this->kv_white_list_words = array_merge($this->kv_white_list_words, $new_kv_white_list_words);

        $this->white_list_words = array_keys($this->kv_white_list_words);
    }

    /**
     * 获取敏感词白名单
     *
     * @author fdipzone
     * @DateTime 2024-08-20 19:34:47
     *
     * @return array
     */
    public function whiteListWords():array
    {
        return $this->white_list_words;
    }

    /**
     * 检查数据内容中是否包含敏感词
     * 增加白名单保护
     *
     * @author fdipzone
     * @DateTime 2024-08-20 18:57:28
     *
     * @param string $content 数据内容
     * @return boolean true: 包含敏感词, false: 不包含敏感词
     */
    public function isContain(string $content):bool
    {
        // 保护敏感词白名单
        $protect_content = $this->protectWhiteListWords($content);

        // 检查是否包含敏感词
        return $this->sensitive_word_filter->isContain($protect_content);
    }

    /**
     * 敏感词过滤
     * 将数据内容中的敏感词替换为指定字符，返回过滤敏感词后的数据内容
     * 增加白名单保护
     *
     * @author fdipzone
     * @DateTime 2024-08-20 18:57:42
     *
     * @param string $content 数据内容
     * @param string $replacement 敏感词替换字符
     * @return string
     */
    public function filter(string $content, string $replacement='*'):string
    {
        // 保护敏感词白名单
        $protect_content = $this->protectWhiteListWords($content);

        // 过滤敏感词
        $protect_content = $this->sensitive_word_filter->filter($protect_content, $replacement);

        // 还原敏感词白名单
        return $this->resumeWhiteListWords($protect_content);
    }

    /**
     * 保护数据内容中的敏感词白名单
     *
     * @author fdipzone
     * @DateTime 2024-08-21 18:59:54
     *
     * @param string $content 数据内容
     * @return string
     */
    private function protectWhiteListWords(string $content):string
    {
        $white_list_words = $this->whiteListWords();

        if($white_list_words)
        {
            foreach($white_list_words as $index=>$word)
            {
                $content = str_replace($word, '[[#'.$index.'#]]', $content);
            }
        }

        return $content;
    }

    /**
     * 还原数据内容中被保护的敏感词白名单
     *
     * @author fdipzone
     * @DateTime 2024-08-21 19:00:46
     *
     * @param string $content 已加白名单保护的数据内容
     * @return string
     */
    private function resumeWhiteListWords(string $content):string
    {
        $white_list_words = $this->whiteListWords();

        if($white_list_words)
        {
            // 定义匿名回调替换方法
            $replace_callback = function(array $matches) use($white_list_words) : string
            {
                $key = isset($matches[1])? $matches[1] : -1;
                return isset($white_list_words[$key])? $white_list_words[$key] : '';
            };

            $content = preg_replace_callback("/\[\[#(.*?)#\]\].*?/si", $replace_callback, $content);
        }

        return $content;
    }
}