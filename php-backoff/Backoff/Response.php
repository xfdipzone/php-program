<?php
namespace Backoff;

/**
 * 定义算法返回结构
 *
 * @author fdipzone
 * @DateTime 2024-05-19 12:07:04
 *
 */
class Response
{
    /**
     * 是否重试
     * true: 重试
     * false: 不再重试
     *
     * @var boolean
     */
    private $retry = true;

    /**
     * 重试等待时间间隔（秒）
     * 当 retry 为 true 时生效
     * 当 retry 为 false 时为 0
     *
     * @var int
     */
    private $retry_interval = 0;

    /**
     * 初始化，设置算法计算结果
     *
     * @author fdipzone
     * @DateTime 2024-05-19 12:22:59
     *
     * @param boolean $retry 是否重试
     * @param int $retry_interval 重试等待时间间隔（秒）
     */
    public function __construct(bool $retry, int $retry_interval)
    {
        // 检查参数
        if($retry_interval<0)
        {
            throw new \Exception('retry interval cannot be less than 0');
        }

        $this->retry = $retry;
        $this->retry_interval = $retry_interval;
    }

    /**
     * 获取是否重试状态
     *
     * @author fdipzone
     * @DateTime 2024-05-19 12:21:07
     *
     * @return boolean
     */
    public function retry():bool
    {
        return $this->retry;
    }

    /**
     * 获取重试等待时间间隔（秒）
     *
     * @author fdipzone
     * @DateTime 2024-05-19 12:21:11
     *
     * @return int
     */
    public function retryInterval():int
    {
        return $this->retry_interval;
    }
}