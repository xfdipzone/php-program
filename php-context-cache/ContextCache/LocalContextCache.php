<?php
namespace ContextCache;

/**
 * 定义基于本地 HashMap 实现的上下文缓存组件
 * 使用本地 HashMap 保存数据
 * 不支持跨服务设置与获取数据，只支持在同一个请求中设置与获取数据
 *
 * @author fdipzone
 * @DateTime 2024-02-21 19:35:55
 *
 */
class LocalContextCache implements IContextCache
{
    /**
     * 用于存储缓存数据
     * key => value
     * value 数据支持多种类型 (mixed)
     *
     * @var array
     */
    private $cache = [];

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
    public function Put(string $key, $data):bool
    {
        $this->cache[$key] = $data;
        return true;
    }

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
    public function Get(string $key)
    {
        if(isset($this->cache[$key]))
        {
            return $this->cache[$key];
        }
        else
        {
            return null;
        }
    }

    /**
     * 移除缓存数据
     *
     * @author fdipzone
     * @DateTime 2024-02-21 19:30:44
     *
     * @param string $key 缓存标识
     * @return boolean
     */
    public function Remove(string $key):bool
    {
        if(isset($this->cache[$key]))
        {
            unset($this->cache[$key]);
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * 清空所有缓存数据
     *
     * @author fdipzone
     * @DateTime 2024-02-21 19:31:36
     *
     * @return void
     */
    public function Clear():void
    {
        $this->cache = [];
    }
}