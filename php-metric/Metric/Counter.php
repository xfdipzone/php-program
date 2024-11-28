<?php
namespace Metric;

/**
 * 基于执行次数实现的 Metric
 * 支持回调功能
 *
 * @author fdipzone
 * @DateTime 2024-03-09 18:47:33
 *
 */
class Counter implements IMetric, IMetricCallback
{
    /**
     * 最大可执行次数
     *
     * @var int
     */
    private $max_times;

    /**
     * 当前已执行的次数
     *
     * @var int
     */
    private $cur_times = 0;

    /**
     * 回调方法
     *
     * @var callable
     */
    private $callback;

    /**
     * 初始化，设置最大可执行次数
     *
     * @author fdipzone
     * @DateTime 2024-03-09 19:07:57
     *
     * @param int $max_times 最大可执行次数
     */
    public function __construct(int $max_times)
    {
        // 检查最大可执行次数
        if($max_times<1)
        {
            throw new \Exception('max times must be greater than 0');
        }

        $this->max_times = $max_times;
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
        // 当前执行次数 +1
        $this->cur_times ++;

        // 已到达最大可执行次数
        if($this->cur_times>=$this->max_times)
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
        $this->callback = $callback;
    }
}