<?php
namespace ContextCache;

/**
 * 定义上下文缓存组件接口
 *
 * @author fdipzone
 * @DateTime 2024-02-21 19:23:55
 *
 */
interface IContextCache
{
    /**
     * 设置缓存数据
     *
     * @author fdipzone
     * @DateTime 2024-02-21 19:29:41
     *
     * @param string $key 缓存标识
     * @param mixed $data 数据
     * @return boolean
     */
    public function Put(string $key, $data):bool;

    /**
     * 获取缓存数据
     * 数据不存在时返回 null
     *
     * @author fdipzone
     * @DateTime 2024-02-21 19:30:15
     *
     * @param string $key 缓存标识
     * @return mixed
     */
    public function Get(string $key);

    /**
     * 移除缓存数据
     *
     * @author fdipzone
     * @DateTime 2024-02-21 19:30:44
     *
     * @param string $key 缓存标识
     * @return boolean
     */
    public function Remove(string $key):bool;

    /**
     * 清空所有缓存数据
     *
     * @author fdipzone
     * @DateTime 2024-02-21 19:31:36
     *
     * @return void
     */
    public function Clear():void;
}