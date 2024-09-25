<?php
namespace SharedData;

/**
 * 基于共享内存实现的数据共享类
 *
 * @author fdipzone
 * @DateTime 2024-09-22 22:33:42
 *
 */
class SharedMemory implements \SharedData\ISharedData
{
    /**
     * 共享数据标识
     *
     * @var string
     */
    private $shared_key;

    /**
     * 共享数据最大容量（字节）
     *
     * @var int
     */
    private $shared_size;

    /**
     * 初始化
     * 设置共享数据标识与共享数据块容量
     *
     * @author fdipzone
     * @DateTime 2024-09-22 23:02:47
     *
     * @param string $shared_key 共享数据标识
     * @param int $shared_size 共享数据最大容量（字节）
     */
    public function __construct(string $shared_key, int $shared_size)
    {
        if(empty($shared_key))
        {
            throw new \Exception('shared memory: shared key is empty');
        }

        $this->shared_key = $shared_key;
        $this->shared_size = $shared_size;
    }

    /**
     * 设置共享数据
     *
     * @author fdipzone
     * @DateTime 2024-09-22 19:35:10
     *
     * @param string $data 数据
     * @return boolean
     */
    public function store(string $data):bool
    {
        return true;
    }

    /**
     * 读取共享数据
     *
     * @author fdipzone
     * @DateTime 2024-09-22 19:35:23
     *
     * @return string
     */
    public function load():string
    {
        return '';
    }

    /**
     * 清空共享数据
     *
     * @author fdipzone
     * @DateTime 2024-09-22 19:35:33
     *
     * @return boolean
     */
    public function clear():bool
    {
        return true;
    }

    /**
     * 关闭共享数据
     *
     * @author fdipzone
     * @DateTime 2024-09-22 19:35:48
     *
     * @return boolean
     */
    public function close():bool
    {
        return true;
    }

    /**
     * 获取信号唯一id
     *
     * @author fdipzone
     * @DateTime 2024-09-25 22:21:22
     *
     * @return \SysvSemaphore
     */
    private function semId():\SysvSemaphore
    {
        $project_id = $this->shared_key.'-sem';
        $sem_key = ftok(__FILE__, $project_id);
        return sem_get($sem_key, 1, 0666, 1);
    }

    /**
     * 获取共享数据进程通信标识
     *
     * @author fdipzone
     * @DateTime 2024-09-25 22:26:27
     *
     * @return int
     */
    private function shmKey():int
    {
        $project_id = $this->shared_key.'-shm';
        $shm_key = ftok(__FILE__, $project_id);
        return $shm_key;
    }
}