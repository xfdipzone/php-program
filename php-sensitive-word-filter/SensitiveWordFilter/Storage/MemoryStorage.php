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
     * 敏感词集合 KV 结构
     * key=>value key:敏感词 value:true
     * 用于过滤重复敏感词与加速追加处理
     *
     * @var array
     */
    private $kv_sensitive_words = [];

    /**
     * 敏感词集合
     *
     * @var array
     */
    private $sensitive_words = [];

    /**
     * 设置敏感词数据源
     * 此方法可多次调用，追加敏感词列表
     *
     * @author fdipzone
     * @DateTime 2024-08-16 22:49:28
     *
     * @param \SensitiveWordFilter\Resource $resource 敏感词数据源
     * @return void
     */
    public function setResource(\SensitiveWordFilter\Resource $resource):void
    {
        if($resource->type()!=\SensitiveWordFilter\Resource::MEMORY)
        {
            throw new \Exception('memory storage: resource type not match');
        }

        if(!$resource->getWords())
        {
            throw new \Exception('memory storage: sensitive words is empty');
        }

        $new_kv_sensitive_words = array_fill_keys($resource->getWords(), true);
        $this->kv_sensitive_words = array_merge($this->kv_sensitive_words, $new_kv_sensitive_words);

        $this->sensitive_words = array_keys($this->kv_sensitive_words);
    }

    /**
     * 获取敏感词集合
     *
     * @author fdipzone
     * @DateTime 2024-08-08 18:17:32
     *
     * @return array [敏感词1,敏感词2,敏感词3,...敏感词n]
     */
    public function sensitiveWords():array
    {
        return $this->sensitive_words;
    }
}