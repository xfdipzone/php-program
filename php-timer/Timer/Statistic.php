<?php
namespace Timer;

/**
 * 统计时间线事件用时
 * 计算总用时与各事件用时
 *
 * @author fdipzone
 * @DateTime 2024-08-26 16:28:38
 *
 */
class Statistic
{
    /**
     * 时间线
     *
     * @var \Timer\Timeline
     */
    private $timeline;

    /**
     * 初始化，传入时间线对象
     *
     * @author fdipzone
     * @DateTime 2024-08-26 16:30:27
     *
     * @param \Timer\Timeline $timeline
     */
    public function __construct(\Timer\Timeline $timeline)
    {
        // 检查 timeline 是否有效
        $events = $timeline->events();
        if(count($events)<2)
        {
            throw new \Exception('timer statistic: timeline invalid');
        }

        $this->timeline = $timeline;
    }

    /**
     * 计算总用时 (ms)
     *
     * @author fdipzone
     * @DateTime 2024-08-26 16:31:16
     *
     * @return int
     */
    public function totalTime():int
    {
        $events = $this->timeline->events();
        $events_num = count($events);

        // 获取开始事件
        $start_event = $events[0];

        // 获取结束事件
        $end_event = $events[$events_num-1];

        // 计算总用时
        return $end_event->millisecondTimestamp() - $start_event->millisecondTimestamp();
    }

    /**
     * 计算明细用时
     * 计算每个事件用时及执行到当前事件时总流程用时
     *
     * @author fdipzone
     * @DateTime 2024-08-26 16:32:23
     *
     * @return array
     */
    public function detailTime():array
    {
        $result = [];
        $events = $this->timeline->events();

        // 上一个事件执行时间戳 (ms)
        $prev_event_time = 0;

        // timeline 开始时间
        $start_time = 0;

        foreach($events as $event)
        {
            $millisecond_timestamp = $event->millisecondTimestamp();
            $second = (int)($millisecond_timestamp / 1000);
            $millisecond = $millisecond_timestamp % 1000;

            $result[] = array(
                'time' => date('Y-m-d H:i:s', $second).'.'.$millisecond,
                'content' => $event->content(),
                'execution_time' => $prev_event_time>0? ($millisecond_timestamp - $prev_event_time) : 0,
                'flow_execution_time' => $start_time>0? ($millisecond_timestamp - $start_time) : 0,
            );

            if($start_time==0)
            {
                $start_time = $millisecond_timestamp;
            }

            $prev_event_time = $millisecond_timestamp;
        }

        return $result;
    }
}