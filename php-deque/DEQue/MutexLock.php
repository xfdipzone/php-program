<?php
namespace DEQue;

/**
 * 并发锁
 * 基于 SyncMutex 实现
 *
 * @author fdipzone
 * @DateTime 2024-08-18 22:41:39
 *
 */
class MutexLock
{
    /**
     * SyncMutex 锁
     *
     * @var \SyncMutex
     */
    private $mutex;

    /**
     * 初始化
     * 设置锁标识
     *
     * @author fdipzone
     * @DateTime 2024-08-18 22:43:32
     *
     * @param string $key 并发锁标识
     */
    public function __construct(string $key='')
    {
        $this->mutex = new \SyncMutex($key);
    }

    /**
     * 加锁
     *
     * @author fdipzone
     * @DateTime 2024-08-18 22:45:58
     *
     * @param int $wait 等待时间(ms) -1 表示一直等待
     * @return boolean
     */
    public function lock(int $wait=-1):bool
    {
        return $this->mutex->lock($wait);
    }

    /**
     * 解锁
     *
     * @author fdipzone
     * @DateTime 2024-08-18 22:48:36
     *
     * @return boolean
     */
    public function unlock():bool
    {
        return $this->mutex->unlock();
    }
}