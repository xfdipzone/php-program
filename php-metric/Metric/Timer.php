<?php
namespace Metric;

/**
 * 基于执行时间实现的 Metric
 * 支持回调功能
 *
 * @author fdipzone
 * @DateTime 2024-03-09 18:49:25
 *
 */
class Timer implements IMetric, IMetricCallback
{
    /**
     * 最大可执行秒数
     *
     * @var int
     */
    private $max_seconds;

    /**
     * 开始执行时间
     *
     * @var int
     */
    private $start_time;

    /**
     * 回调方法
     *
     * @var callable
     */
    private $callback;

    /**
     * 初始化，设置最大可执行秒数
     *
     * @author fdipzone
     * @DateTime 2024-03-10 17:18:30
     *
     * @param integer $max_seconds
     */
    public function __construct(int $max_seconds)
    {
        // 检查最大可执行秒数
        if($max_seconds<1)
        {
            throw new \Exception('max seconds must be greater than 0');
        }

        $this->start_time = time();
        $this->max_seconds = $max_seconds;
    }

    /**
     * 判断条件是否满足继续执行
     *
     * @author fdipzone
     * @DateTime 2024-03-09 18:34:50
     *
     * @return boolean
     */
    public function next():bool
    {
        // 已到达最大可执行时间
        if(time()>=$this->start_time+$this->max_seconds)
        {
            // 有设置回调方法，执行回调
            if($this->callback)
            {
                ($this->callback)();
            }

            return false;
        }
        return true;
    }

    /**
     * 设置回调方法
     *
     * @author fdipzone
     * @DateTime 2024-03-09 18:36:53
     *
     * @param callable $callback 回调方法
     * @return void
     */
    public function setCallback(callable $callback):void
    {
        // 检查回调方法
        if(!is_callable($callback))
        {
            throw new \Exception('callback is not callable');
        }

        $this->callback = $callback;
    }
}