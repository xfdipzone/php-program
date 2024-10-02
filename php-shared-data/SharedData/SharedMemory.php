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
     * 共享内存 IPC 文件，用于 ftok 方法生成 System V IPC key
     * https://www.php.net/manual/en/function.ftok.php
     *
     * @var string
     */
    private $shm_ipc_file = '';

    /**
     * 信号量 IPC 文件
     *
     * @var string
     */
    private $sem_ipc_file = '';

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

        if($shared_size<1)
        {
            throw new \Exception('shared memory: shared size must be greater than 0');
        }

        $this->shared_key = $shared_key;
        $this->shared_size = $shared_size;

        // 创建共享内存 IPC 文件
        $this->shm_ipc_file = '/tmp/'.$this->shared_key.'.ipc';

        $created = $this->createIpcFile($this->shm_ipc_file);
        if(!$created)
        {
            throw new \Exception('shared memory: shm ipc file already exists or create fail');
        }

        // 创建信号量 IPC 文件
        $this->sem_ipc_file = '/tmp/'.$this->shared_key.'-sem.ipc';

        $created = $this->createIpcFile($this->sem_ipc_file);
        if(!$created)
        {
            throw new \Exception('shared memory: sem ipc file already exists or create fail');
        }
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

        if(mb_strlen($data, 'utf8')>$this->shared_size)
        {
            throw new \Exception('shared memory: store data length more than shared memory size');
        }

        try
        {
            // 获取信号量锁标识
            $sem_id = $this->semId();

            // 获取信号量锁（阻塞等待）
            if(!sem_acquire($sem_id))
            {
                throw new \Exception('shared memory: semaphore acquire fail');
            }

            $shm_key = $this->shmKey();

            if($shm_key==-1)
            {
                throw new \Exception('shared memory: shm_key invalid');
            }

            $shm_id = shmop_open($shm_key, 'c', 0644, $this->shared_size);

            if(!$shm_id)
            {
                throw new \Exception('shared memory: shm_id create fail');
            }

            // 获取已用共享内存大小
            $shm_size = shmop_size($shm_id);

            // 清空共享内存数据
            shmop_write($shm_id, str_repeat("\0", $shm_size), 0);

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
        finally
        {
            // 释放信号量锁
            sem_release($sem_id);
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
            // 获取信号量锁标识
            $sem_id = $this->semId();

            // 获取信号量锁（阻塞等待）
            if(!sem_acquire($sem_id))
            {
                throw new \Exception('shared memory: semaphore acquire fail');
            }

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

            // 去除数据结尾多余的 \0
            return rtrim($data, "\0");
        }
        catch(\Throwable $e)
        {
            throw new \Exception($e->getMessage());
        }
        finally
        {
            // 释放信号量锁
            sem_release($sem_id);
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
            // 获取信号量锁标识
            $sem_id = $this->semId();

            // 获取信号量锁（阻塞等待）
            if(!sem_acquire($sem_id))
            {
                throw new \Exception('shared memory: semaphore acquire fail');
            }

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
        finally
        {
            // 释放信号量锁
            sem_release($sem_id);
        }
    }

    /**
     * 关闭共享数据
     * 关闭后将不能执行任何操作，例如写入，读取等
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
            // 获取信号量锁标识
            $sem_id = $this->semId();

            // 获取信号量锁（阻塞等待）
            if(!sem_acquire($sem_id))
            {
                throw new \Exception('shared memory: semaphore acquire fail');
            }

            $shm_id = shmop_open($this->shmKey(), 'w', 0, 0);

            if(!$shm_id)
            {
                throw new \Exception('shared memory: shm_id get fail');
            }

            // 删除共享内存段
            $deleted = shmop_delete($shm_id);

            // 关闭共享内存块标识符
            $this->closeShmId($shm_id);

            // 删除共享内存 IPC 文件
            $this->removeIpcFile($this->shm_ipc_file);

            return $deleted;
        }
        catch(\Throwable $e)
        {
            throw new \Exception($e->getMessage());
        }
        finally
        {
            // 释放信号量锁
            sem_release($sem_id);
        }
    }

    /**
     * 创建 IPC 文件
     *
     * @author fdipzone
     * @DateTime 2024-09-27 11:53:09
     *
     * @return boolean
     */
    /**
     * 创建 IPC 文件
     *
     * @author fdipzone
     * @DateTime 2024-09-27 15:57:10
     *
     * @param string $ipc_file IPC 文件
     * @return boolean
     */
    private function createIpcFile(string $ipc_file):bool
    {
        // 检查文件是否存在
        if(file_exists($ipc_file))
        {
            return false;
        }

        // 创建文件
        return file_put_contents($ipc_file, '')!==false;
    }

    /**
     * 删除 IPC 文件
     *
     * @author fdipzone
     * @DateTime 2024-09-27 17:04:58
     *
     * @param string $ipc_file IPC 文件
     * @return boolean
     */
    private function removeIpcFile(string $ipc_file):bool
    {
        if(file_exists($ipc_file))
        {
            return unlink($ipc_file);
        }

        return false;
    }

    /**
     * 获取信号量唯一id
     *
     * @author fdipzone
     * @DateTime 2024-09-25 22:21:22
     *
     * @return mixed
     */
    private function semId()
    {
        // Project identifier. This must be a one character string.
        $project_id = 's';
        $sem_key = ftok($this->sem_ipc_file, $project_id);

        if($sem_key==-1)
        {
            return false;
        }

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
        // Project identifier. This must be a one character string.
        $project_id = 'm';
        $shm_key = ftok($this->shm_ipc_file, $project_id);
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
    private function closeShmId($shm_id):void
    {
        // Warning: This function has been DEPRECATED as of PHP 8.0.0. Relying on this function is highly discouraged.
        shmop_close($shm_id);
    }
}