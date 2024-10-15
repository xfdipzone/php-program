<?php
namespace SharedData;

/**
 * 共享 Key Value 存储数据接口
 * 定义共享数据 KV 存储类需要实现的方法
 *
 * @author fdipzone
 * @DateTime 2024-10-11 18:45:33
 *
 */
interface IKVSharedStorage
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
    public function store(string $key, $data):bool;

    /**
     * 读取 KV 共享数据
     *
     * @author fdipzone
     * @DateTime 2024-10-11 18:49:37
     *
     * @param string $key 数据键
     * @return mixed
     */
    public function load(string $key);

    /**
     * 移除 KV 共享数据
     *
     * @author fdipzone
     * @DateTime 2024-10-11 18:49:41
     *
     * @param string $key 数据键
     * @return boolean
     */
    public function remove(string $key):bool;

    /**
     * 关闭 KV 共享存储
     * 关闭后将不能执行任何操作，例如写入，读取等
     *
     * @author fdipzone
     * @DateTime 2024-10-11 18:49:46
     *
     * @return boolean
     */
    public function close():bool;
}