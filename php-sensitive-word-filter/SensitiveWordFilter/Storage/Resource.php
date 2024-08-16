<?php
namespace SensitiveWordFilter\Storage;

/**
 * 敏感词列表来源
 *
 * @author fdipzone
 * @DateTime 2024-08-15 19:56:49
 *
 */
class Resource
{
    // 来源类型：Memory
    const MEMORY = 'memory';

    // 来源类型：File
    const FILE = 'file';

    /**
     * 来源类型
     *
     * @var string
     */
    private $type;

    /**
     * 敏感词列表
     *
     * @var array
     */
    private $sensitive_words = [];

    /**
     * 敏感词文件
     *
     * @var string
     */
    private $sensitive_word_file = '';

    /**
     * 初始化
     * 设置敏感词列表来源
     *
     * @author fdipzone
     * @DateTime 2024-08-15 19:58:57
     *
     * @param string $type 敏感词列表来源类型
     */
    public function __construct(string $type)
    {
        if(!in_array($type, [self::MEMORY, self::FILE]))
        {
            throw new \Exception(sprintf('resource: type %s not exists', $type));
        }

        $this->type = $type;
    }

    /**
     * 获取敏感词来源类型
     *
     * @author fdipzone
     * @DateTime 2024-08-16 22:50:50
     *
     * @return string
     */
    public function type():string
    {
        return $this->type;
    }

    /**
     * 设置敏感词列表
     * 类型为 Memory 时调用
     *
     * @author fdipzone
     * @DateTime 2024-08-15 21:53:38
     *
     * @param array $sensitive_words 敏感词列表
     * @return void
     */
    public function setWords(array $sensitive_words):void
    {
        if($this->type!=self::MEMORY)
        {
            throw new \Exception('resource: type not match');
        }

        if(!$sensitive_words)
        {
            throw new \Exception('resource: sensitive words is empty');
        }

        $this->sensitive_words = $sensitive_words;
    }

    /**
     * 获取敏感词列表
     *
     * @author fdipzone
     * @DateTime 2024-08-15 21:55:24
     *
     * @return array
     */
    public function getWords():array
    {
        if($this->type!=self::MEMORY)
        {
            throw new \Exception('resource: type not match');
        }

        return $this->sensitive_words;
    }

    /**
     * 设置敏感词文件路径
     * 类型为 File 时调用
     *
     * @author fdipzone
     * @DateTime 2024-08-15 21:53:55
     *
     * @param string $sensitive_word_file 敏感词文件路径
     * @return void
     */
    public function setFile(string $sensitive_word_file):void
    {
        if($this->type!=self::FILE)
        {
            throw new \Exception('resource: type not match');
        }

        if(!file_exists($sensitive_word_file))
        {
            throw new \Exception('resource: sensitive word file not exists');
        }

        $this->sensitive_word_file = $sensitive_word_file;
    }

    /**
     * 获取敏感词文件路径
     *
     * @author fdipzone
     * @DateTime 2024-08-15 21:56:13
     *
     * @return string
     */
    public function getFile():string
    {
        if($this->type!=self::FILE)
        {
            throw new \Exception('resource: type not match');
        }

        return $this->sensitive_word_file;
    }
}