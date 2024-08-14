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
     * 敏感词集合
     * key=>value key:敏感词 value:true
     *
     * @var array
     */
    private $sensitive_words = [];

    /**
     * 从敏感词文件中读取敏感词列表
     * 此方法可多次调用，读取多个文件的敏感词，追加到敏感词列表
     *
     * @author fdipzone
     * @DateTime 2024-08-11 18:43:23
     *
     * @param string $sensitive_word_file 敏感词文件路径
     * @return void
     */
    public function save(string $sensitive_word_file):void
    {
        if(!file_exists($sensitive_word_file))
        {
            throw new \Exception('file storage: sensitive word file not exists');
        }

        $new_sensitive_words = $this->parseSensitiveWordFile($sensitive_word_file);
        $this->sensitive_words = array_merge($this->sensitive_words, $new_sensitive_words);
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
        return array_keys($this->sensitive_words);
    }
}