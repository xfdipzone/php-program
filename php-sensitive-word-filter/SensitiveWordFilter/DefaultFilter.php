<?php
namespace SensitiveWordFilter;

/**
 * 默认敏感词过滤器
 *
 * @author fdipzone
 * @DateTime 2024-08-14 21:19:10
 *
 */
class DefaultFilter implements \SensitiveWordFilter\ISensitiveWordFilter
{
    /**
     * 敏感词存储
     *
     * @var \SensitiveWordFilter\Storage\IStorage
     */
    private $sensitive_word_storage;

    /**
     * 初始化
     * 传入敏感词存储对象
     *
     * @author fdipzone
     * @DateTime 2024-08-14 21:26:43
     *
     * @param \SensitiveWordFilter\Storage\IStorage $sensitive_word_storage
     */
    public function __construct(\SensitiveWordFilter\Storage\IStorage $sensitive_word_storage)
    {
        $this->sensitive_word_storage = $sensitive_word_storage;
    }

    /**
     * 检查数据内容中是否包含敏感词
     *
     * @author fdipzone
     * @DateTime 2024-08-14 21:20:45
     *
     * @param string $content 数据内容
     * @return boolean true: 包含敏感词, false: 不包含敏感词
     */
    public function isContain(string $content):bool
    {
        $sensitive_words = $this->sensitive_word_storage->sensitiveWords();

        if($sensitive_words)
        {
            foreach($sensitive_words as $word)
            {
                if(strpos($content, $word)!==false)
                {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * 敏感词过滤
     * 将数据内容中的敏感词替换为指定字符，返回过滤敏感词后的数据内容
     *
     * @author fdipzone
     * @DateTime 2024-08-14 21:20:58
     *
     * @param string $content 数据内容
     * @param string $replacement 敏感词替换字符
     * @return string
     */
    public function filter(string $content, string $replacement='*'):string
    {
        if($replacement=='')
        {
            throw new \Exception('default filter: replacement can not be empty');
        }

        $sensitive_words = $this->sensitive_word_storage->sensitiveWords();
        if($sensitive_words)
        {
            $content = str_replace($sensitive_words, $replacement, $content);
        }

        return $content;
    }
}