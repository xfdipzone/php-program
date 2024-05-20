<?php
namespace Backoff;

/**
 * 指数退避算法
 *
 * @author fdipzone
 * @DateTime 2024-05-19 12:40:08
 *
 */
class ExponentialBackoff implements \Backoff\IBackoff
{
    /**
     * 初始化重试等待时间间隔（秒）
     *
     * @var int
     */
    private $start_retry_interval;

    /**
     * 最大重试等待时间间隔（秒）
     * 用途：封顶
     *
     * @var int
     */
    private $max_retry_interval;

    /**
     * 指数退避因子（倍数）
     *
     * @var int
     */
    private $factor;

    /**
     * 最大重试次数
     *
     * @var int
     */
    private $max_retry_times;

    /**
     * 随机因子
     * 增加随机等待时间上限（秒）
     *
     * @var int
     */
    private $random_factor = 0;

    /**
     * 初始化，设置配置参数
     *
     * @author fdipzone
     * @DateTime 2024-05-19 13:12:40
     *
     */
    public function __construct(int $start_retry_interval, int $max_retry_interval, int $factor, int $max_retry_times)
    {
        // 检查参数
        if($start_retry_interval<1)
        {
            throw new \Exception('start retry interval must be greater than 0');
        }

        if($max_retry_interval<=$start_retry_interval)
        {
            throw new \Exception('max retry interval must be greater than start retry interval');
        }

        if($factor<1)
        {
            throw new \Exception('factor must be greater than 0');
        }

        if($max_retry_times<1)
        {
            throw new \Exception('max retry times must be greater than 0');
        }

        $this->start_retry_interval = $start_retry_interval;
        $this->max_retry_interval = $max_retry_interval;
        $this->factor = $factor;
        $this->max_retry_times = $max_retry_times;
    }

    /**
     * 设置随机因子
     *
     * @author fdipzone
     * @DateTime 2024-05-19 21:06:10
     *
     * @param int $random_factor 随机因子
     * @return void
     */
    public function setRandomFactor(int $random_factor):void
    {
        if($random_factor<1)
        {
            throw new \Exception('random factor must be greater than 0');
        }

        $this->random_factor = $random_factor;
    }

    /**
     * 根据随机因子计算随机附加时间间隔
     *
     * @author fdipzone
     * @DateTime 2024-05-19 21:10:34
     *
     * @return int
     */
    private function randomInterval():int
    {
        if($this->random_factor>0)
        {
            return mt_rand(0, $this->random_factor);
        }

        return 0;
    }

    /**
     * 退避算法计算，获取计算结果
     * 计算结果包括是否可以重试及重试等待时间间隔
     *
     * @author fdipzone
     * @DateTime 2024-05-19 12:07:53
     *
     * @param \Backoff\Request $request 算法请求结构
     * @return \Backoff\Response
     */
    public function next(\Backoff\Request $request):\Backoff\Response
    {
        // 当前已执行的重试次数
        $retry_times = $request->retryTimes();

        // 判断是否到达最大重试次数
        if($retry_times >= $this->max_retry_times)
        {
            $response = new \Backoff\Response(false, 0);
            return $response;
        }

        // 计算重试等待时间间隔
        $retry_interval = $this->start_retry_interval * pow($this->factor, $retry_times);

        // 判断是否到达最大重试等待时间间隔
        if($retry_interval >= $this->max_retry_interval)
        {
            $retry_interval = $this->max_retry_interval;
        }

        // 增加随机因子
        $retry_interval = $retry_interval + $this->randomInterval();

        $response = new \Backoff\Response(true, $retry_interval);
        return $response;
    }
}
