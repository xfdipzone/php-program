<?php
namespace SharedData;

/**
 * 共享内存通用方法集合
 *
 * @author fdipzone
 * @DateTime 2024-10-12 22:45:18
 *
 */
class SharedMemoryUtils
{
    /**
     * 创建 IPC 文件
     *
     * @author fdipzone
     * @DateTime 2024-10-12 22:48:05
     *
     * @param string $ipc_file IPC 文件
     * @return boolean
     */
    public static function createIpcFile(string $ipc_file):bool
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
     * @DateTime 2024-10-12 22:48:05
     *
     * @param string $ipc_file IPC 文件
     * @return boolean
     */
    public static function removeIpcFile(string $ipc_file):bool
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
     * @DateTime 2024-10-12 22:53:37
     *
     * @param string $sem_ipc_file 信号量 IPC 文件
     * @param string $project_id Project identifier. This must be a one character string.
     * @return mixed
     */
    public static function semId(string $sem_ipc_file, string $project_id)
    {
        $sem_key = ftok($sem_ipc_file, $project_id);

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
     * @DateTime 2024-10-12 22:53:55
     *
     * @param string $shm_ipc_file 共享内存 IPC 文件
     * @param string $project_id Project identifier. This must be a one character string.
     * @return int
     */
    public static function shmKey(string $shm_ipc_file, string $project_id):int
    {
        $shm_key = ftok($shm_ipc_file, $project_id);
        return $shm_key;
    }
}