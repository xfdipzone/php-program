<?php
namespace Bucket;

/**
 * php 基于Redis实现Bucket类
 *
 * @author fdipzone
 * @DateTime 2023-04-01 19:28:12
 *
 * Description
 * php基于Redis实现Bucket类，使用Redis的List存储类型（先入先出）作为容器存放数据。使用了共享锁及Redis事务，保证并发执行的唯一性。
 *
 * Func:
 * public init            初始化
 * public push            压入数据
 * public pop             弹出数据
 * public setMaxSize      设置最大容量
 * public maxSize         获取最大容量
 * public usedSize        获取已用容量
 * public setLockTimeout  设置锁过期时间（毫秒）
 * public setTimeout      设置执行超时时间（毫秒）
 * public setRetryTime    设置重试间隔时间（毫秒）
 */
class RedisBucket implements IBucket
{
    // 错误码（传入参数不合法）
    const REQUEST_PARAM_INVALID = 1;

    // 错误码（没有数据可以弹出）
    const NO_DATA_TO_POP = 2;

    // 错误码（超时）
    const TIMEOUT = 99;

    /**
     * Redis config
     *
     * @var array
     */
    private $_config;

    /**
     * Redis连接
     *
     * @var \Redis
     */
    private $_conn;

    /**
     * bucket (key)
     *
     * @var string
     */
    private $_bucket = '';

    /**
     * bucket 最大容量 (key)
     *
     * @var string
     */
    private $_bucket_max_size = '';

    /**
     * bucket 已用容量 (key)
     *
     * @var string
     */
    private $_bucket_used_size = '';

    /**
     * bucket 锁 (key)
     *
     * @var string
     */
    private $_bucket_lock = '';

    /**
     * bucket 锁过期时间（毫秒）
     *
     * @var int
     */
    private $_bucket_lock_timeout = 300;

    /**
     * 执行超时时间（毫秒）
     *
     * @var int
     */
    private $_timeout = 2000;

    /**
     * 重试间隔时间（毫秒）
     *
     * @var int
     */
    private $_retry_time = 25;

    /**
     *  构造方法，检查参数是否正确
     *
     * @author fdipzone
     * @DateTime 2023-04-02 19:15:58
     *
     * @param array $config redis连接设定
     * @param string $bucket bucket名称
     */
    public function __construct(array $config, string $bucket)
    {
        $this->_config = $config;
        $this->_conn = $this->connect();
        $this->_bucket = $bucket;
        $this->_bucket_max_size = $bucket . ':max';
        $this->_bucket_used_size = $bucket . ':used';
        $this->_bucket_lock = $bucket . ':lock';

        // 检查连接
        if (!method_exists($this->_conn, 'ping')) {
            throw new \Exception('connect not ping');
        }

        if ($this->_conn->ping() == false) {
            throw new \Exception('connect error');
        }

        // 检查bucket
        if (!is_string($bucket) || $bucket == '') {
            throw new \Exception('bucket error or empty');
        }
    }

    /**
     * 初始化bucket数据，重置数据为0，清空bucket数据
     *
     * @author fdipzone
     * @DateTime 2023-04-02 19:16:55
     *
     * @return void
     */
    public function init(): void
    {
        // 设置最大容量
        $this->_conn->set($this->_bucket_max_size, 0);

        // 设置已用容量
        $this->_conn->set($this->_bucket_used_size, 0);

        // 设置bucket数据
        $this->_conn->del($this->_bucket);
    }

    /**
     * 压入数据
     *
     * @author fdipzone
     * @DateTime 2023-04-02 19:17:46
     *
     * @param string $data 压入的数据
     * @param int $is_force_pop 是否强制弹出数据（已满的情况），默认不弹出
     * @return Response
     */
    public function push(string $data, int $is_force_pop = 0): Response
    {
        // 记录开始执行时间
        $start_time = $this->getMilliSecondTimestamp();

        // 未到超时时间，循环执行直到获取锁
        while (($start_time + $this->_timeout) >= $this->getMilliSecondTimestamp()) {

            // 获取锁
            $is_lock = $this->lock();

            // 获取锁成功
            if ($is_lock) {

                try {
                    // 监视bucket状态
                    $this->_conn->watch(array($this->_bucket, $this->_bucket_used_size, $this->_bucket_max_size));

                    // 判断是否已满
                    $is_full = $this->isFull();

                    if ($is_full) {

                        // 不强制弹出数据
                        if (!$is_force_pop) {

                            // 取消监控
                            $this->_conn->unwatch(array($this->_bucket, $this->_bucket_used_size, $this->_bucket_max_size));

                            return $this->ret_data(self::REQUEST_PARAM_INVALID);
                        }
                    }

                    // 开启事务
                    $this->_conn->multi();

                    // 容器已满且强制弹出数据
                    if ($is_full && $is_force_pop) {

                        // 弹出数据
                        $this->_conn->rPop($this->_bucket);

                        // 减少已用容量
                        $this->_conn->decr($this->_bucket_used_size);
                    }

                    // 压入数据
                    $this->_conn->lPush($this->_bucket, $data);

                    // 增加已用容量
                    $this->_conn->incr($this->_bucket_used_size);

                    // 执行事务
                    $ret = $this->_conn->exec();

                    // 事务执行失败
                    if ($ret === false) {
                        continue;
                    }

                    $result = array();

                    // 容器已满且强制弹出数据
                    if ($is_full && $is_force_pop) {
                        $result = array(
                            'used_size' => isset($ret[2]) ? intval($ret[2]) : 0,
                            'force_pop_data' => isset($ret[0]) ? array($ret[0]) : array(),
                        );
                    // 没有弹出数据
                    } else {
                        $result = array(
                            'used_size' => isset($ret[0]) ? intval($ret[0]) : 0,
                            'force_pop_data' => array(),
                        );
                    }

                    return $this->ret_data(0, $result);
                } finally {
                    // 释放锁
                    $this->unlock();
                }

            // 获取锁失败，延迟重试
            } else {
                usleep($this->_retry_time * 1000);
            }
        }

        // 执行超时
        return $this->ret_data(self::TIMEOUT);
    }

    /**
     * 弹出数据
     *
     * @author fdipzone
     * @DateTime 2023-04-02 19:18:50
     *
     * @param int $num 弹出数据数量
     * @return Response
     */
    public function pop(int $num = 1): Response
    {
        // 检查num
        if ($num <= 0) {
            return $this->ret_data(self::REQUEST_PARAM_INVALID);
        }

        // 记录开始执行时间
        $start_time = $this->getMilliSecondTimestamp();

        // 未到超时时间，循环执行直到获取锁
        while (($start_time + $this->_timeout) >= $this->getMilliSecondTimestamp()) {

            // 获取锁
            $is_lock = $this->lock();

            // 获取锁成功
            if ($is_lock) {

                try {
                    // 监视bucket状态
                    $this->_conn->watch(array($this->_bucket, $this->_bucket_used_size, $this->_bucket_max_size));

                    // 检查数量是否足够，不足够将全部数据弹出
                    if (!$this->checkStock($num)) {
                        $num = $this->usedSize();
                    }

                    // 检查是否存在数据
                    if ($num <= 0) {

                        // 取消监控
                        $this->_conn->unwatch(array($this->_bucket, $this->_bucket_used_size, $this->_bucket_max_size));

                        return $this->ret_data(self::NO_DATA_TO_POP);
                    }

                    // 开启事务
                    $this->_conn->multi();

                    $i = 0;

                    // 循环
                    while ($i < $num) {

                        // 弹出数据
                        $this->_conn->rPop($this->_bucket);

                        // 减少已用容量
                        $this->_conn->decr($this->_bucket_used_size);

                        $i++;
                    }

                    // 执行事务
                    $ret = $this->_conn->exec();

                    // 事务执行失败
                    if ($ret === false) {
                        continue;
                    }

                    // 获取弹出数据
                    if (is_array($ret)) {
                        $filter_ret = array_values(array_filter($ret, function ($var) {
                            return (!($var & 1));
                        }, ARRAY_FILTER_USE_KEY));

                        return $this->ret_data(0, $filter_ret);
                    }

                    return $this->ret_data(0);
                } finally {
                    // 释放锁
                    $this->unlock();
                }

            // 获取锁失败，延迟重试
            } else {
                usleep($this->_retry_time * 1000);
            }
        }

        // 执行超时
        return $this->ret_data(self::TIMEOUT);
    }

    /**
     * 设置最大容量
     *
     * @author fdipzone
     * @DateTime 2023-04-02 19:19:39
     *
     * @param int $size 容量大小
     * @return Response
     */
    public function setMaxSize(int $size): Response
    {
        // 检查size
        if ($size < 0) {
            return $this->ret_data(self::REQUEST_PARAM_INVALID);
        }

        // 记录开始执行时间
        $start_time = $this->getMilliSecondTimestamp();

        // 未到超时时间，循环执行直到获取锁
        while (($start_time + $this->_timeout) >= $this->getMilliSecondTimestamp()) {

            // 获取锁
            $is_lock = $this->lock();

            // 获取锁成功
            if ($is_lock) {

                try {
                    // 监视bucket状态
                    $this->_conn->watch(array($this->_bucket, $this->_bucket_used_size, $this->_bucket_max_size));

                    // 获取当前已用容量
                    $cur_used_size = $this->usedSize();

                    // 当前已用容量比要设置的最大容量大
                    if ($cur_used_size > $size) {
                        $force_pop_size = intval($cur_used_size - $size);
                    } else {
                        $force_pop_size = 0;
                    }

                    // 开启事务
                    $this->_conn->multi();

                    // 需要强制弹出数据
                    if ($force_pop_size > 0) {
                        for ($i = 0; $i < $force_pop_size; $i++) {
                            $this->_conn->rPop($this->_bucket);
                        }

                        // 设置已用容量
                        $this->_conn->set($this->_bucket_used_size, $size);
                    }

                    // 设置最大容量
                    $this->_conn->set($this->_bucket_max_size, $size);

                    // 执行事务
                    $ret = $this->_conn->exec();

                    // 事务执行失败
                    if ($ret === false) {
                        continue;
                    }

                    // 返回弹出数据
                    if ($force_pop_size > 0) {
                        if (is_array($ret)) {
                            return $this->ret_data(0, array_slice($ret, 0, $force_pop_size));
                        }
                    }

                    return $this->ret_data(0);
                } finally {
                    // 释放锁
                    $this->unlock();
                }

            // 获取锁失败，延迟重试
            } else {
                usleep($this->_retry_time * 1000);
            }
        }

        // 执行超时
        return $this->ret_data(self::TIMEOUT);
    }

    /**
     * 获取最大容量
     *
     * @author fdipzone
     * @DateTime 2023-04-02 19:22:03
     *
     * @return int
     */
    public function maxSize(): int
    {
        return intval($this->_conn->get($this->_bucket_max_size));
    }

    /**
     * 获取已用容量
     *
     * @author fdipzone
     * @DateTime 2023-04-02 19:22:40
     *
     * @return int
     */
    public function usedSize(): int
    {
        return intval($this->_conn->get($this->_bucket_used_size));
    }

    /**
     * 设置锁过期时间（毫秒）
     *
     * @author fdipzone
     * @DateTime 2023-04-02 19:23:36
     *
     * @param int $lock_timeout 锁过期时间（毫秒）
     * @return void
     */
    public function setLockTimeout(int $lock_timeout): void
    {
        // 设置锁过期时间（毫秒）
        if (is_numeric($lock_timeout) && $lock_timeout > 0) {
            $this->_bucket_lock_timeout = (int)($lock_timeout);
        } else {
            throw new \Exception('set lock timeout error');
        }
    }

    /**
     * 设置执行超时时间（毫秒）
     *
     * @author fdipzone
     * @DateTime 2023-04-02 19:25:10
     *
     * @param int $timeout 执行超时时间（毫秒）
     * @return void
     */
    public function setTimeout(int $timeout): void
    {
        // 执行超时时间（毫秒）
        if (is_numeric($timeout) && $timeout > 0) {
            $this->_timeout = (int)($timeout);
        } else {
            throw new \Exception('set timeout error');
        }
    }

    /**
     * 设置重试间隔时间（毫秒）
     *
     * @author fdipzone
     * @DateTime 2023-04-02 19:25:44
     *
     * @param int $time 重试间隔时间（毫秒）
     * @return void
     */
    public function setRetryTime(int $time): void
    {
        // 重试间隔时间（毫秒）
        if (is_numeric($time) && $time > 0) {
            $this->_retry_time = (int)($time);
        } else {
            throw new \Exception('set retry time error');
        }
    }

    /**
     * 判断容器是否已满
     *
     * @author fdipzone
     * @DateTime 2023-04-02 19:31:24
     *
     * @return boolean
     */
    private function isFull(): bool
    {
        $max_size = $this->maxSize();
        $used_size = $this->usedSize();

        if ($used_size >= $max_size) {
            return true;
        }

        return false;
    }

    /**
     * 检查已使用容量是否足够弹出
     *
     * @author fdipzone
     * @DateTime 2023-04-02 19:31:47
     *
     * @param int $num 弹出的数量
     * @return boolean
     */
    private function checkStock(int $num): bool
    {
        $used_size = $this->usedSize();

        if ($used_size >= $num) {
            return true;
        }

        return false;
    }

    /**
     * 获取锁
     *
     * @author fdipzone
     * @DateTime 2023-04-02 19:36:56
     *
     * @return boolean
     */
    private function lock(): bool
    {
        $is_lock = $this->_conn->setnx($this->_bucket_lock, $this->getMilliSecondTimestamp() + $this->_bucket_lock_timeout);

        // 不能获取锁
        if (!$is_lock) {

            // 判断锁是否过期
            $lock_time = $this->_conn->get($this->_bucket_lock);

            // 锁已过期，删除锁，重新获取
            if ($this->getMilliSecondTimestamp() > $lock_time) {
                $this->unlock();
                $is_lock = $this->_conn->setnx($this->_bucket_lock, $this->getMilliSecondTimestamp() + $this->_bucket_lock_timeout);
            }
        }

        return $is_lock ? true : false;
    }

    /**
     * 释放锁
     *
     * @author fdipzone
     * @DateTime 2023-04-02 19:38:42
     *
     * @return boolean
     */
    private function unlock(): bool
    {
        return $this->_conn->del($this->_bucket_lock) ? true : false;
    }

    /**
     * 获取毫秒级时间戳
     *
     * @author fdipzone
     * @DateTime 2023-04-02 22:48:26
     *
     * @return int
     */
    private function getMilliSecondTimestamp(): int
    {
        list($usec, $sec) = explode(' ', microtime());
        $millisecond_timestamp = $sec . str_pad((int)(($usec * 1000)), 3, '0', STR_PAD_LEFT);
        return $millisecond_timestamp;
    }

    /**
     * 返回数据
     *
     * @author fdipzone
     * @DateTime 2023-04-02 22:46:29
     *
     * @param int $error 错误码
     * @param mixed $data 返回数据
     * @return Response
     */
    private function ret_data(int $error, $data = array()): Response
    {
        $response = new Response;
        $response->setError($error);
        $response->setData($data);
        return $response;
    }

    /**
     * 创建redis连接
     *
     * @author fdipzone
     * @DateTime 2023-04-02 22:44:35
     *
     * @return \Redis
     */
    private function connect(): \Redis
    {
        try {
            $redis = new \Redis();
            $redis->connect($this->_config['host'], $this->_config['port'], $this->_config['timeout'], $this->_config['reserved'], $this->_config['retry_interval']);
            if (empty($this->_config['auth'])) {
                $redis->auth($this->_config['auth']);
            }
            $redis->select($this->_config['index']);
        } catch (\Throwable $e) {
            throw new \Exception($e->getMessage());
        }
        return $redis;
    }

}