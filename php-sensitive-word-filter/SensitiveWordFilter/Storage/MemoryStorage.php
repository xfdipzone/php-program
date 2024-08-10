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
     * 初始化
     * 设置敏感词列表
     *
     * @author fdipzone
     * @DateTime 2024-08-08 18:16:33
     *
     * @param array $sensitive_words 敏感词列表
     */
    public function __construct(array $sensitive_words)
    {
        if(!$sensitive_words)
        {
            throw new \Exception('memory storage: sensitive words is empty');
        }

        $this->sensitive_words = array_fill_keys($sensitive_words, true);
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