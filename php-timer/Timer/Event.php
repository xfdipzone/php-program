<?php
namespace Timer;

/**
 * 时间事件
 * 用于记录某个时间执行的事件内容
 *
 * @author fdipzone
 * @DateTime 2024-08-25 18:25:14
 *
 */
class Event
{
    /**
     * 时间戳（毫秒级别）
     *
     * @var int
     */
    private $millisecond_timestamp;

    /**
     * 事件内容
     *
     * @var string
     */
    private $content;

    /**
     * 初始化
     *
     * @author fdipzone
     * @DateTime 2024-08-25 18:27:11
     *
     * @param int $millisecond_timestamp 时间戳（毫秒级别）
     * @param string $content 标记内容
     */
    public function __construct(int $millisecond_timestamp, string $content)
    {
        if($millisecond_timestamp<=0)
        {
            throw new \Exception('timer event: millisecond timestamp invalid');
        }
    
        if(empty($content))
        {
            throw new \Exception('timer event: content is empty');
        }

        $this->millisecond_timestamp = $millisecond_timestamp;
        $this->content = $content;
    }

    /**
     * 获取事件时间（毫秒级）
     *
     * @author fdipzone
     * @DateTime 2024-08-25 18:41:13
     *
     * @return int
     */
    public function millisecondTimestamp():int
    {
        return $this->millisecond_timestamp;
    }

    /**
     * 获取事件内容
     *
     * @author fdipzone
     * @DateTime 2024-08-25 18:41:06
     *
     * @return string
     */
    public function content():string
    {
        return $this->content;
    }
}