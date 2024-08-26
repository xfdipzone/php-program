<?php
namespace Timer;

/**
 * 时间事件采集器
 * 用于采集时间事件，生成时间线
 *
 * @author fdipzone
 * @DateTime 2024-08-25 18:14:50
 *
 */
class Collector
{
    // 状态：未开始统计
    const NOT_STARTED = 0;

    // 状态：已开始统计
    const STARTED = 1;

    // 状态：已结束统计
    const ENDED = 2;

    /**
     * 当前状态
     *
     * @var int
     */
    private $state = self::NOT_STARTED;

    /**
     * 时间线
     * 用于记录事件执行时序
     *
     * @var \Timer\Timeline
     */
    private $timeline = [];

    /**
     * 初始化
     *
     * @author fdipzone
     * @DateTime 2024-08-25 18:16:57
     *
     */
    public function __construct()
    {
        $this->timeline = new \Timer\Timeline;
    }

    /**
     * 开始采集
     * 记录开始执行时间
     *
     * @author fdipzone
     * @DateTime 2024-08-25 17:01:55
     *
     * @return void
     */
    public function start():void
    {
        if($this->state!=self::NOT_STARTED)
        {
            throw new \Exception('timer collector: the current state cannot be started');
        }

        // 状态设置为开始
        $this->state = self::STARTED;

        // 记录开始时间
        $event = new \Timer\Event($this->getMilliSecondTimestamp(), 'start');
        $this->timeline->push($event);
    }

    /**
     * 结束采集
     * 记录结束执行时间
     *
     * @author fdipzone
     * @DateTime 2024-08-25 17:02:32
     *
     * @return void
     */
    public function end():void
    {
        if($this->state!=self::STARTED)
        {
            throw new \Exception('timer collector: the current state cannot be ended');
        }

        // 状态设置为结束
        $this->state = self::ENDED;

        // 记录结束时间
        $event = new \Timer\Event($this->getMilliSecondTimestamp(), 'end');
        $this->timeline->push($event);
    }

    /**
     * 设置标注点
     * 开始采集之后，设置执行流程中间的标注点，用于统计执行到某个标注点所用时间
     *
     * @author fdipzone
     * @DateTime 2024-08-25 17:04:47
     *
     * @param string $content 标注点说明
     * @return void
     */
    public function savePoint(string $content):void
    {
        if($this->state!=self::STARTED)
        {
            throw new \Exception('timer collector: the current state cannot be save point');
        }

        if(empty($content))
        {
            throw new \Exception('timer collector: save point content is empty');
        }

        // 记录标注时间及内容
        $event = new \Timer\Event($this->getMilliSecondTimestamp(), $content);
        $this->timeline->push($event);
    }

    /**
     * 获取时间线
     *
     * @author fdipzone
     * @DateTime 2024-08-25 18:37:52
     *
     * @return \Timer\Timeline
     */
    public function timeline():\Timer\Timeline
    {
        if($this->state!=self::ENDED)
        {
            throw new \Exception('timer collector: the current state cannot be get timeline');
        }

        return $this->timeline;
    }

    /**
     * 获取毫秒级时间戳
     *
     * @author fdipzone
     * @DateTime 2024-08-25 17:22:01
     *
     * @return int
     */
    private function getMilliSecondTimestamp():int
    {
        list($usec, $sec) = explode(' ', microtime());
        $millisecond_timestamp = $sec . str_pad((int)(($usec * 1000)), 3, '0', STR_PAD_LEFT);
        return $millisecond_timestamp;
    }
}