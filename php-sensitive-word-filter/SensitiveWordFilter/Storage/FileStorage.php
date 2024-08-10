<?php
namespace SensitiveWordFilter\Storage;

/**
 * 基于文件存储敏感词
 * 文件一行存储一个敏感词
 *
 * @author fdipzone
 * @DateTime 2024-08-10 23:18:53
 *
 */
class FileStorage implements \SensitiveWordFilter\Storage\IStorage
{
    /**
     * 敏感词文件路径
     *
     * @var string
     */
    private $sensitive_word_file;

    /**
     * 敏感词集合
     * key=>value key:敏感词 value:true
     *
     * @var array
     */
    private $sensitive_words = [];

    /**
     * 初始化
     * 设置敏感词文件路径
     *
     * @author fdipzone
     * @DateTime 2024-08-10 23:21:41
     *
     * @param string $sensitive_word_file 敏感词文件路径
     */
    public function __construct(string $sensitive_word_file)
    {
        if(!file_exists($sensitive_word_file))
        {
            throw new \Exception('file storage: sensitive word file not exists');
        }

        $this->sensitive_word_file = $sensitive_word_file;
    }

    /**
     * 获取敏感词集合
     *
     * @author fdipzone
     * @DateTime 2024-08-10 23:24:16
     *
     * @return array
     */
    public function sensitiveWords():array
    {
        return $this->sensitive_words;
    }
}