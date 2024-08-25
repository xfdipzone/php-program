<?php
namespace Timer;

/**
 * 时间线，用于记录多个时间序列
 *
 * @author fdipzone
 * @DateTime 2024-08-25 18:17:35
 *
 */
class Timeline
{
    /**
     * 时间事件集合
     * 用于按执行时间顺序存储时间事件
     *
     * @var array [] \Timer\Event
     */
    private $events = [];

    /**
     * 加入时间事件
     *
     * @author fdipzone
     * @DateTime 2024-08-25 18:31:34
     *
     * @param \Timer\Event $event 时间事件
     * @return void
     */
    public function push(\Timer\Event $event):void
    {
        array_push($this->events, $event);
    }

    /**
     * 获取时间线时间事件集合
     *
     * @author fdipzone
     * @DateTime 2024-08-25 18:39:31
     *
     * @return array 数组元素为 \Timer\Event
     */
    public function events():array
    {
        return $this->events;
    }
}