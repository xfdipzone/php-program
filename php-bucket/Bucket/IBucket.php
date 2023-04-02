<?php
namespace Bucket;

/**
 * 定义Bucket类接口
 *
 * @author fdipzone
 * @DateTime 2023-04-01 17:37:56
 *
 */
interface IBucket{

    /**
     * 构造函数，初始化bucket类
     *
     * @author fdipzone
     * @DateTime 2023-04-01 19:23:07
     *
     * @param array $config bucket类配置
     * @param string $bucket bucket名称
     */
    public function __construct(array $config, string $bucket);

    /**
     * 初始化bucket数据，重置数据为0，清空bucket数据
     *
     * @author fdipzone
     * @DateTime 2023-04-01 19:33:49
     *
     * @return void
     */
    public function init():void;

    /**
     * Undocumented function
     *
     * @author fdipzone
     * @DateTime 2023-04-01 19:46:07
     *
     * @param string $data 压入的数据
     * @param int $is_force_pop 是否强制弹出数据（已满的情况），默认不弹出
     * @return Response
     */
    public function push(string $data, int $is_force_pop=0):Response;

    /**
     * 弹出数据
     *
     * @author fdipzone
     * @DateTime 2023-04-01 19:47:24
     *
     * @param int $num 弹出数据数量
     * @return Response
     */
    public function pop(int $num=1):Response;

    /**
     * 设置最大容量
     *
     * @author fdipzone
     * @DateTime 2023-04-01 19:54:00
     *
     * @param int $size 容量大小
     * @return Response
     */
    public function setMaxSize(int $size):Response;

    /**
     * 获取最大容量
     *
     * @author fdipzone
     * @DateTime 2023-04-01 19:54:51
     *
     * @return int
     */
    public function maxSize():int;

    /**
     * 获取已用容量
     *
     * @author fdipzone
     * @DateTime 2023-04-01 20:14:57
     *
     * @return int
     */
    public function usedSize():int;

    /**
     * 设置锁过期时间（毫秒）
     *
     * @author fdipzone
     * @DateTime 2023-04-01 20:16:10
     *
     * @param int $lock_timeout 锁过期时间（毫秒）
     * @return void
     */
    public function setLockTimeout(int $lock_timeout):void;

    /**
     * 设置执行超时时间（毫秒）
     *
     * @author fdipzone
     * @DateTime 2023-04-01 20:17:02
     *
     * @param int $timeout 执行超时时间（毫秒）
     * @return void
     */
    public function setTimeout(int $timeout):void;

    /**
     * 设置重试间隔时间（毫秒）
     *
     * @author fdipzone
     * @DateTime 2023-04-01 20:17:31
     *
     * @param int $time 重试间隔时间（毫秒）
     * @return void
     */
    public function setRetryTime(int $time):void;

}