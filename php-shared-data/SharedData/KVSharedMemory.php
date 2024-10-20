<?php
namespace SharedData;

/**
 * 基于共享内存实现的 KV 存储类
 *
 * @author fdipzone
 * @DateTime 2024-10-11 18:59:19
 *
 */
class KVSharedMemory implements \SharedData\IKVSharedStorage
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
     * @DateTime 2024-10-14 16:40:11
     *
     * @param string $shared_key 共享数据标识
     * @param int $shared_size 共享数据最大容量（字节）
     * @param boolean $init 是否初始化
     */
    public function __construct(string $shared_key, int $shared_size, bool $init=false)
    {
        if(empty($shared_key))
        {
            throw new \Exception('kv shared memory: shared key is empty');
        }

        if($shared_size<1)
        {
            throw new \Exception('kv shared memory: shared size must be greater than 0');
        }

        $this->shared_key = $shared_key;
        $this->shared_size = $shared_size;

        // 创建共享内存 IPC 文件
        $this->shm_ipc_file = '/tmp/'.$this->shared_key.'-kv.ipc';

        if($init)
        {
            $created = \SharedData\SharedMemoryUtils::createIpcFile($this->shm_ipc_file);
            if(!$created)
            {
                throw new \Exception('kv shared memory: shm ipc file already exists or create fail');
            }
        }
        else
        {
            if(!file_exists($this->shm_ipc_file))
            {
                throw new \Exception('kv shared memory: shm ipc file not exists');
            }
        }

        // 创建信号量 IPC 文件
        $this->sem_ipc_file = '/tmp/'.$this->shared_key.'-kv-sem.ipc';

        if($init)
        {
            $created = \SharedData\SharedMemoryUtils::createIpcFile($this->sem_ipc_file);
            if(!$created)
            {
                throw new \Exception('kv shared memory: sem ipc file already exists or create fail');
            }
        }
        else
        {
            if(!file_exists($this->sem_ipc_file))
            {
                throw new \Exception('kv shared memory: sem ipc file not exists');
            }
        }
    }

    /**
     * 存储 KV 共享数据
     *
     * @author fdipzone
     * @DateTime 2024-10-11 18:49:33
     *
     * @param string $key 数据键
     * @param mixed $data 数据
     * @return boolean
     */
    public function store(string $key, $data):bool
    {
        if(empty($key))
        {
            throw new \Exception('kv shared memory: store key is empty');
        }

        if(empty($data))
        {
            throw new \Exception('kv shared memory: store data is empty');
        }

        try
        {
            // 获取信号量锁标识
            $sem_id = \SharedData\SharedMemoryUtils::semId($this->sem_ipc_file, 's');

            // 获取信号量锁（阻塞等待）
            if(!sem_acquire($sem_id))
            {
                throw new \Exception('kv shared memory: semaphore acquire fail');
            }

            $shm_key = \SharedData\SharedMemoryUtils::shmKey($this->shm_ipc_file, 'm');

            if($shm_key==-1)
            {
                throw new \Exception('kv shared memory: shm_key invalid');
            }

            $shm_id = shm_attach($shm_key, $this->shared_size, 0755);

            if(!$shm_id)
            {
                throw new \Exception('kv shared memory: shm_id create fail');
            }

            // 写入共享内存 KV 数据
            $written = shm_put_var($shm_id, $this->keyConvert($key), $data);

            // 关闭共享内存块连接
            shm_detach($shm_id);

            return $written? true : false;
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
     * 读取 KV 共享数据
     *
     * @author fdipzone
     * @DateTime 2024-10-11 18:49:37
     *
     * @param string $key 数据键
     * @return mixed
     */
    public function load(string $key)
    {
        if(empty($key))
        {
            throw new \Exception('kv shared memory: load key is empty');
        }

        try
        {
            // 获取信号量锁标识
            $sem_id = \SharedData\SharedMemoryUtils::semId($this->sem_ipc_file, 's');

            // 获取信号量锁（阻塞等待）
            if(!sem_acquire($sem_id))
            {
                throw new \Exception('kv shared memory: semaphore acquire fail');
            }

            $shm_key = \SharedData\SharedMemoryUtils::shmKey($this->shm_ipc_file, 'm');

            if($shm_key==-1)
            {
                throw new \Exception('kv shared memory: shm_key invalid');
            }

            $shm_id = shm_attach($shm_key, $this->shared_size, 0755);

            if(!$shm_id)
            {
                throw new \Exception('kv shared memory: shm_id get fail');
            }

            // 读取共享内存 KV 数据
            $data = shm_get_var($shm_id, $this->keyConvert($key));

            // 关闭共享内存块连接
            shm_detach($shm_id);

            return $data;
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
     * 移除 KV 共享数据
     *
     * @author fdipzone
     * @DateTime 2024-10-11 18:49:41
     *
     * @param string $key 数据键
     * @return boolean
     */
    public function remove(string $key):bool
    {
        if(empty($key))
        {
            throw new \Exception('kv shared memory: remove key is empty');
        }

        try
        {
            // 获取信号量锁标识
            $sem_id = \SharedData\SharedMemoryUtils::semId($this->sem_ipc_file, 's');

            // 获取信号量锁（阻塞等待）
            if(!sem_acquire($sem_id))
            {
                throw new \Exception('kv shared memory: semaphore acquire fail');
            }

            $shm_key = \SharedData\SharedMemoryUtils::shmKey($this->shm_ipc_file, 'm');

            if($shm_key==-1)
            {
                throw new \Exception('kv shared memory: shm_key invalid');
            }

            $shm_id = shm_attach($shm_key, $this->shared_size, 0755);

            if(!$shm_id)
            {
                throw new \Exception('kv shared memory: shm_id get fail');
            }

            $removed = false;
            $int_key = $this->keyConvert($key);

            // 判断 key 是否存在
            if(shm_has_var($shm_id, $int_key))
            {
                $removed = shm_remove_var($shm_id, $int_key);
            }

            // 关闭共享内存块连接
            shm_detach($shm_id);

            return $removed;
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
     * 关闭 KV 共享存储
     * 关闭后将不能执行任何操作，例如写入，读取等
     *
     * @author fdipzone
     * @DateTime 2024-10-11 18:49:46
     *
     * @return boolean
     */
    public function close():bool
    {
        try
        {
            $deleted = false;

            // 获取信号量锁标识
            $sem_id = \SharedData\SharedMemoryUtils::semId($this->sem_ipc_file, 's');

            // 获取信号量锁（阻塞等待）
            if(!sem_acquire($sem_id))
            {
                throw new \Exception('kv shared memory: semaphore acquire fail');
            }

            $shm_key = \SharedData\SharedMemoryUtils::shmKey($this->shm_ipc_file, 'm');

            if($shm_key==-1)
            {
                throw new \Exception('kv shared memory: shm_key invalid');
            }

            $shm_id = shm_attach($shm_key, $this->shared_size, 0755);

            if(!$shm_id)
            {
                throw new \Exception('kv shared memory: shm_id get fail');
            }

            // 删除共享内存段
            $deleted = shm_remove($shm_id);

            // 关闭共享内存块连接
            shm_detach($shm_id);

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

            if($deleted)
            {
                // 删除信号量锁
                sem_remove($sem_id);

                // 删除信号量 IPC 文件
                \SharedData\SharedMemoryUtils::removeIpcFile($this->sem_ipc_file);

                // 删除共享内存 IPC 文件
                \SharedData\SharedMemoryUtils::removeIpcFile($this->shm_ipc_file);
            }
        }
    }

    /**
     * 将 key 转为无符号整型数字
     *
     * @author fdipzone
     * @DateTime 2024-10-14 17:57:55
     *
     * @param string $key 数据键
     * @return int
     */
    private function keyConvert(string $key):int
    {
        $hex_str = hash('crc32b', $key);
        return hexdec($hex_str);
    }
}