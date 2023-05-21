<?php
namespace Captcha\Storage;

/**
 * 定义Captcha存储类接口
 *
 * @author fdipzone
 * @DateTime 2023-05-20 23:42:39
 *
 */
interface IStorage{

    /**
     * 初始化，设置配置类对象
     *
     * @author fdipzone
     * @DateTime 2023-05-21 12:13:22
     *
     * @param IStorageConfig $config 存储配置对象
     */
    public function __construct(IStorageConfig $config);

    /**
     * 保存数据
     *
     * @author fdipzone
     * @DateTime 2023-05-21 11:50:21
     *
     * @param string $key  标识
     * @param string $data 数据
     * @return boolean
     */
    public function save(string $key, string $data):bool;

    /**
     * 获取数据
     *
     * @author fdipzone
     * @DateTime 2023-05-21 11:50:41
     *
     * @param string $key 标识
     * @return string
     */
    public function get(string $key):string;

    /**
     * 删除存储的数据
     *
     * @author fdipzone
     * @DateTime 2023-05-21 11:50:54
     *
     * @param string $key 标识
     * @return boolean
     */
    public function delete(string $key):bool;

}