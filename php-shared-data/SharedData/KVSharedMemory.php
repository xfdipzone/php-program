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
        return true;
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
        return '';
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
        return true;
    }

    /**
     * 关闭 KV 共享存储
     *
     * @author fdipzone
     * @DateTime 2024-10-11 18:49:46
     *
     * @return boolean
     */
    public function close():bool
    {
        return true;
    }
}