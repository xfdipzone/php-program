<?php
namespace Backoff;

/**
 * 定义算法请求结构
 *
 * @author fdipzone
 * @DateTime 2024-05-19 12:06:59
 *
 */
class Request
{
    /**
     * 已重试次数
     *
     * @var int
     */
    private $retry_times = 0;

    /**
     * 初始化，设置算法请求参数
     *
     * @author fdipzone
     * @DateTime 2024-05-19 12:33:10
     *
     * @param int $retry_times 已重试次数
     */
    public function __construct(int $retry_times=0)
    {
        // 检查参数
        if($retry_times<0)
        {
            throw new \Exception('retry times cannot be less than 0');
        }

        $this->retry_times = $retry_times;
    }

    /**
     * 获取已重试次数
     *
     * @author fdipzone
     * @DateTime 2024-05-19 12:33:58
     *
     * @return int
     */
    public function retryTimes():int
    {
        return $this->retry_times;
    }
}