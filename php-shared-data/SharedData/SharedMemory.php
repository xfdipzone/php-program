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
        if(empty($data))
        {
            throw new \Exception('shared memory: store data is empty');
        }

        try
        {
            $shm_id = shmop_open($this->shmKey(), 'c', 0644, $this->shared_size);

            if(!$shm_id)
            {
                throw new \Exception('shared memory: shm_id create fail');
            }

            // 获取已用共享内存大小
            $shm_size = shmop_size($shm_id);

            // 清空共享内存数据
            $clear_size = shmop_write($shm_id, str_repeat("\0", $shm_size), 0);

            if($clear_size===false)
            {
                return false;
            }

            // 写入共享内存数据
            $written_size = shmop_write($shm_id, $data, 0);

            // 关闭共享内存块标识符
            $this->closeShmId($shm_id);

            return $written_size===false? false : true;

        }
        catch(\Throwable $e)
        {
            throw new \Exception($e->getMessage());
        }
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
        try
        {
            $shm_id = shmop_open($this->shmKey(), 'a', 0, 0);

            if(!$shm_id)
            {
                throw new \Exception('shared memory: shm_id get fail');
            }

            // 获取已用共享内存大小
            $shm_size = shmop_size($shm_id);

            // 读取共享内存数据
            $data = shmop_read($shm_id, 0, $shm_size);

            // 关闭共享内存块标识符
            $this->closeShmId($shm_id);

            return $data;
        }
        catch(\Throwable $e)
        {
            throw new \Exception($e->getMessage());
        }
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
        try
        {
            $shm_id = shmop_open($this->shmKey(), 'w', 0, 0);

            if(!$shm_id)
            {
                throw new \Exception('shared memory: shm_id get fail');
            }

            // 获取已用共享内存大小
            $shm_size = shmop_size($shm_id);

            // 清空共享内存数据
            $clear_size = shmop_write($shm_id, str_repeat("\0", $shm_size), 0);

            // 关闭共享内存块标识符
            $this->closeShmId($shm_id);

            return $clear_size===false? false : true;
        }
        catch(\Throwable $e)
        {
            throw new \Exception($e->getMessage());
        }
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
        try
        {
            $shm_id = shmop_open($this->shmKey(), 'w', 0, 0);

            if(!$shm_id)
            {
                throw new \Exception('shared memory: shm_id get fail');
            }

            // 删除共享内存段
            $deleted = shmop_delete($shm_id);

            // 关闭共享内存块标识符
            $this->closeShmId($shm_id);

            return $deleted;
        }
        catch(\Throwable $e)
        {
            throw new \Exception($e->getMessage());
        }
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

    /**
     * 关闭共享内存块调用
     *
     * @author fdipzone
     * @DateTime 2024-09-26 20:07:45
     *
     * @param \Shmop $shm_id 共享内存块标识符
     * @return void
     */
    private function closeShmId(\Shmop $shm_id):void
    {
        // Warning: This function has been DEPRECATED as of PHP 8.0.0. Relying on this function is highly discouraged.
        shmop_close($shm_id);
    }
}