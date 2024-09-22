<?php
namespace SharedData;

/**
 * 共享数据接口
 * 定义共享数据类需要实现的方法
 *
 * @author fdipzone
 * @DateTime 2024-09-22 18:54:54
 *
 */
interface ISharedData
{
    /**
     * 设置共享数据
     *
     * @author fdipzone
     * @DateTime 2024-09-22 19:35:10
     *
     * @param string $data 数据
     * @return boolean
     */
    public function store(string $data):bool;

    /**
     * 读取共享数据
     *
     * @author fdipzone
     * @DateTime 2024-09-22 19:35:23
     *
     * @return string
     */
    public function load():string;

    /**
     * 清空共享数据
     *
     * @author fdipzone
     * @DateTime 2024-09-22 19:35:33
     *
     * @return boolean
     */
    public function clear():bool;

    /**
     * 关闭共享数据
     *
     * @author fdipzone
     * @DateTime 2024-09-22 19:35:48
     *
     * @return boolean
     */
    public function close():bool;
}