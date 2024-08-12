<?php
namespace SensitiveWordFilter\Storage;

/**
 * 基于内存存储敏感词
 *
 * @author fdipzone
 * @DateTime 2024-08-08 18:12:56
 *
 */
class MemoryStorage implements \SensitiveWordFilter\Storage\IStorage
{
    /**
     * 敏感词集合
     * key=>value key:敏感词 value:true
     *
     * @var array
     */
    private $sensitive_words = [];

    /**
     * 设置敏感词列表
     * 此方法可多次调用，追加到敏感词列表
     *
     * @author fdipzone
     * @DateTime 2024-08-11 18:42:20
     *
     * @param array $sensitive_words 敏感词列表
     * @return void
     */
    public function save(array $sensitive_words):void
    {
        if(!$sensitive_words)
        {
            throw new \Exception('memory storage: sensitive words is empty');
        }

        $new_sensitive_words = array_fill_keys($sensitive_words, true);
        $this->sensitive_words = array_merge($this->sensitive_words, $new_sensitive_words);
    }

    /**
     * 获取敏感词集合
     *
     * @author fdipzone
     * @DateTime 2024-08-08 18:17:32
     *
     * @return array
     */
    public function sensitiveWords():array
    {
        return $this->sensitive_words;
    }
}