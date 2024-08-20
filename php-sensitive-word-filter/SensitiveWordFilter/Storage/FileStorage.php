<?php
namespace SensitiveWordFilter\Storage;

/**
 * 基于文件存储敏感词
 * 文件一行存储一个敏感词，使用换行符分隔
 *
 * @author fdipzone
 * @DateTime 2024-08-10 23:18:53
 *
 */
class FileStorage implements \SensitiveWordFilter\Storage\IStorage
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
        if($resource->type()!=\SensitiveWordFilter\Resource::FILE)
        {
            throw new \Exception('file storage: resource type not match');
        }

        if(!file_exists($resource->getFile()))
        {
            throw new \Exception('file storage: sensitive word file not exists');
        }

        $new_kv_sensitive_words = $this->parseSensitiveWordFile($resource->getFile());
        $this->kv_sensitive_words = array_merge($this->kv_sensitive_words, $new_kv_sensitive_words);

        $this->sensitive_words = array_keys($this->kv_sensitive_words);
    }

    /**
     * 解析敏感词文件数据为敏感词列表
     *
     * @author fdipzone
     * @DateTime 2024-08-11 18:55:34
     *
     * @param string $sensitive_word_file 敏感词文件路径
     * @return array key=>value key:敏感词 value:true
     */
    private function parseSensitiveWordFile(string $sensitive_word_file):array
    {
        $sensitive_words = [];

        $file_data = file_get_contents($sensitive_word_file);
        $file_sensitive_words = explode(PHP_EOL, $file_data);

        if(count($file_sensitive_words)>0)
        {
            foreach($file_sensitive_words as $word)
            {
                $word = str_replace(array(' ', chr(10), chr(13)), '', $word);
                if($word!='')
                {
                    $sensitive_words[$word] = true;
                }
            }
        }

        return $sensitive_words;
    }

    /**
     * 获取敏感词集合
     *
     * @author fdipzone
     * @DateTime 2024-08-10 23:24:16
     *
     * @return array [敏感词1,敏感词2,敏感词3,...敏感词n]
     */
    public function sensitiveWords():array
    {
        return $this->sensitive_words;
    }
}