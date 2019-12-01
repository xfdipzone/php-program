<?php
/**
 * PHP基于Redis实现Bucket类
 * Date:    2019-12-01
 * Author:  fdipzone
 * Version: 1.0
 *
 * Description
 * php基于Redis实现Bucket类，使用Redis的List存储类型（先入先出）作为容器存放数据。类中使用了共享锁及Redis事务，保证并发执行的唯一性。
 *
 * Func:
 * public init              初始化
 * public push              压入数据
 * public pop               弹出数据
 * public set_max_size      设置最大容量
 * public get_max_size      获取最大容量
 * public get_used_size     获取已用容量
 * public set_lock_timeout  设置锁过期时间（毫秒）
 * public set_timeout       设置执行超时时间（毫秒）
 * public set_retry_time    设置重试间隔时间（毫秒）
 */
class RedisBucket{ // class start
    
    // 错误码（传入参数不合法）
    const REQUEST_PARAM_INVALID = 1;
    
    // 错误码（没有数据可以弹出）
    const NO_DATA_TO_POP = 2;
    
    // 错误码（超时）
    const TIMEOUT = 99;
    
    // Redis config
    private $_config;

    // Redis连接
    private $_conn;
    
    // bucket (key)
    private $_bucket = '';
    
    // bucket 最大容量 (key)
    private $_bucket_max_size = '';
    
    // bucket 已用容量 (key)
    private $_bucket_used_size = '';
    
    // bucket 锁 (key)
    private $_bucket_lock = '';
    
    // bucket 锁过期时间（毫秒）
    private $_bucket_lock_timeout = 300;
    
    // 执行超时时间（毫秒）
    private $_timeout = 2000;
    
    // 重试间隔时间（毫秒）
    private $_retry_time = 25;
    
    /**
     * 构造方法，检查参数是否正确
     *
     * @param Array   $config redis连接设定
     * @param String  $bucket
     */
    public function __construct($config, $bucket){
        
        $this->_config = $config;
        $this->_conn = $this->connect();
        $this->_bucket = $bucket;
        $this->_bucket_max_size = $bucket.':max';
        $this->_bucket_used_size = $bucket.':used';
        $this->_bucket_lock = $bucket.':lock';
        
        // 检查连接
        if(!method_exists($this->_conn, 'ping')){
            throw new \Exception('connect not ping');
        }
        
        if($this->_conn->ping()==false){
            throw new \Exception('connect error');
        }
        
        // 检查bucket
        if(!is_string($bucket) || $bucket==''){
            throw new \Exception('bucket error or empty');
        }
        
    }
    
    /**
     * 初始化bucket数据，重置数据为0，清空bucket数据
     *
     * @return Boolean
     */
    public function init(){
        
        // 设置最大容量
        $this->_conn->set($this->_bucket_max_size, 0);
        
        // 设置已用容量
        $this->_conn->set($this->_bucket_used_size, 0);
        
        // 设置bucket数据
        $this->_conn->del($this->_bucket);
        
        return true;
        
    }

    /**
     * 压入数据
     *
     * @param  String $data         压入的数据
     * @param  Int    $is_force_pop 是否强制弹出数据（已满的情况），默认不弹出
     * @return Mixed
     */
    public function push($data, $is_force_pop=0){
        
        // 记录开始执行时间
        $start_time = $this->get_milli_timestamp();
        
        // 未到超时时间，循环执行直到获取锁
        while(($start_time + $this->_timeout) >= $this->get_milli_timestamp()){
        
            // 获取锁
            $is_lock = $this->lock();
            
            // 获取锁成功
            if($is_lock){
            
                try{
                
                    // 监视bucket状态
                    $this->_conn->watch(array($this->_bucket, $this->_bucket_used_size, $this->_bucket_max_size));
                    
                    // 判断是否已满
                    $is_full = $this->is_full();
                    
                    if($is_full){
                        
                        // 不强制弹出数据
                        if(!$is_force_pop){
                        
                            // 取消监控
                            $this->_conn->unwatch(array($this->_bucket, $this->_bucket_used_size, $this->_bucket_max_size));
                            
                            return $this->ret_data(self::REQUEST_PARAM_INVALID);
                        
                        }
                        
                    }
                    
                    // 开启事务
                    $this->_conn->multi();
                    
                    // 容器已满且强制弹出数据
                    if($is_full && $is_force_pop){
                        
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
                    if($ret===false){
                        continue;
                    }
                    
                    $result = array();
            
                    // 容器已满且强制弹出数据
                    if($is_full && $is_force_pop){
                        $result = array(
                            'used_size' => isset($ret[2])? intval($ret[2]) : 0,
                            'force_pop_data' => isset($ret[0])? array($ret[0]) : array(),
                        );
                    // 没有弹出数据
                    }else{
                        $result = array(
                            'used_size' => isset($ret[0])? intval($ret[0]) : 0,
                            'force_pop_data' => array(),
                        );
                    }
                    
                    return $this->ret_data(0, $result);
                
                }finally{
                    // 释放锁
                    $this->unlock();
                }
            
            // 获取锁失败，延迟重试
            }else{
                usleep($this->_retry_time*1000);
            }
        
        }
        
        // 执行超时
        return $this->ret_data(self::TIMEOUT);
    
    }
    
    /**
     * 弹出数据
     *
     * @param  Int   $num  弹出数据数量
     * @return Mixed
     */
    public function pop($num=1){
        
        // 检查num
        if($num<=0){
            return $this->ret_data(self::REQUEST_PARAM_INVALID);
        }

        // 记录开始执行时间
        $start_time = $this->get_milli_timestamp();
        
        // 未到超时时间，循环执行直到获取锁
        while(($start_time + $this->_timeout) >= $this->get_milli_timestamp()){
            
            // 获取锁
            $is_lock = $this->lock();
            
            // 获取锁成功
            if($is_lock){
                
                try{
        
                    // 监视bucket状态
                    $this->_conn->watch(array($this->_bucket, $this->_bucket_used_size, $this->_bucket_max_size));
                    
                    // 检查数量是否足够，不足够将全部数据弹出
                    if(!$this->check_stock($num)){
                        $num = $this->get_used_size();
                    }
            
                    // 检查是否存在数据
                    if($num<=0){
                        
                        // 取消监控
                        $this->_conn->unwatch(array($this->_bucket, $this->_bucket_used_size, $this->_bucket_max_size));
                        
                        return $this->ret_data(self::NO_DATA_TO_POP);
                    }
            
                    // 开启事务
                    $this->_conn->multi();
            
                    $i = 0;
                    
                    // 循环
                    while($i<$num){
                        
                        // 弹出数据
                        $this->_conn->rPop($this->_bucket);
                        
                        // 减少已用容量
                        $this->_conn->decr($this->_bucket_used_size);
                       
                        $i++;
                    
                    }
                    
                    // 执行事务
                    $ret = $this->_conn->exec();
                    
                    // 事务执行失败
                    if($ret===false){
                        continue;
                    }
            
                    // 获取弹出数据
                    if(is_array($ret)){
            
                        $filter_ret = array_values(array_filter($ret, function($var){
                            return (!($var & 1));
                        }, ARRAY_FILTER_USE_KEY));
            
                        return $this->ret_data(0, $filter_ret);
            
                    }
            
                    return $this->ret_data(0);
                    
                }finally{
                    // 释放锁
                    $this->unlock();
                }
                
            // 获取锁失败，延迟重试
            }else{
                usleep($this->_retry_time*1000);
            }
            
        }
        
        // 执行超时
        return $this->ret_data(self::TIMEOUT);

    }
    
    /**
     * 设置最大容量
     *
     * @param  Int     $size 容量大小
     * @return Mixed
     */
    public function set_max_size($size){
        
        // 检查size
        if($size<0){
            return $this->ret_data(self::REQUEST_PARAM_INVALID);
        }
        
        // 记录开始执行时间
        $start_time = $this->get_milli_timestamp();
        
        // 未到超时时间，循环执行直到获取锁
        while(($start_time + $this->_timeout) >= $this->get_milli_timestamp()){
            
            // 获取锁
            $is_lock = $this->lock();
            
            // 获取锁成功
            if($is_lock){
                
                try{

                    // 监视bucket状态
                    $this->_conn->watch(array($this->_bucket, $this->_bucket_used_size, $this->_bucket_max_size));
                    
                    // 获取当前已用容量
                    $cur_used_size = $this->get_used_size();
                    
                    // 当前已用容量比要设置的最大容量大
                    if($cur_used_size>$size){
                        $force_pop_size = intval($cur_used_size-$size);
                    }else{
                        $force_pop_size = 0;
                    }
                    
                    // 开启事务
                    $this->_conn->multi();
                    
                    // 需要强制弹出数据
                    if($force_pop_size>0){
                        for($i=0; $i<$force_pop_size; $i++){
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
                    if($ret===false){
                        continue;
                    }
            
                    // 返回弹出数据
                    if($force_pop_size>0){
            
                        if(is_array($ret)){
                            return $this->ret_data(0, array_slice($ret, 0, $force_pop_size));
                        }
            
                    }
            
                    return $this->ret_data(0);
                    
                }finally{
                    // 释放锁
                    $this->unlock();
                }
                
            // 获取锁失败，延迟重试
            }else{
                usleep($this->_retry_time*1000);
            }
            
        }
        
        // 执行超时
        return $this->ret_data(self::TIMEOUT);
        
    }
    
    /**
     * 获取最大容量
     *
     * @return Int
     */
    public function get_max_size(){
        return intval($this->_conn->get($this->_bucket_max_size));
    }
    
    /**
     * 获取已用容量
     *
     * @return Int
     */
    public function get_used_size(){
        return intval($this->_conn->get($this->_bucket_used_size));
    }
    
    /**
     * 设置锁过期时间（毫秒）
     *
     * @param  Int     $lock_timeout 锁过期时间（毫秒）
     * @return Boolean
     */
    public function set_lock_timeout($lock_timeout){
        
        // 设置锁过期时间（毫秒）
        if(is_numeric($lock_timeout) && $lock_timeout>0){
            $this->_bucket_lock_timeout = (int)($lock_timeout);
            return true;
        }
        
        return false;
    
    }
    
    /**
     * 设置执行超时时间（毫秒）
     *
     * @param  Int   $timeout 执行超时时间（毫秒）
     * @return Boolean
     */
    public function set_timeout($timeout){
        
        // 执行超时时间（毫秒）
        if(is_numeric($timeout) && $timeout>0){
            $this->_timeout = (int)($timeout);
            return true;
        }
        
        return false;
        
    }
    
    /**
     * 设置重试间隔时间（毫秒）
     *
     * @param  Int     $time 重试间隔时间（毫秒）
     * @return Boolean
     */
    public function set_retry_time($time){
        
        // 重试间隔时间（毫秒）
        if(is_numeric($time) && $time>0){
            $this->_retry_time = (int)($time);
            return true;
        }
        
        return false;
        
    }
    
    /**
     * 判断容器是否已满
     *
     * @return Boolean
     */
    private function is_full(){
        
        $max_size = $this->get_max_size();
        $used_size = $this->get_used_size();
        
        if($used_size>=$max_size){
            return true;
        }
        
        return false;
        
    }
    
    /**
     * 检查已使用容量是否足够弹出
     *
     * @param  Int $num
     * @return Boolean
     */
    private function check_stock($num){
        
        $used_size = $this->get_used_size();
        
        if($used_size>=$num){
            return true;
        }
        
        return false;
        
    }
    

    /**
     * 获取锁
     *
     * @return Boolean
     */
    private function lock(){
        $is_lock = $this->_conn->setnx($this->_bucket_lock, $this->get_milli_timestamp()+$this->_bucket_lock_timeout);
        
        // 不能获取锁
        if(!$is_lock){
            
            // 判断锁是否过期
            $lock_time = $this->_conn->get($this->_bucket_lock);
            
            // 锁已过期，删除锁，重新获取
            if($this->get_milli_timestamp()>$lock_time){
                $this->unlock();
                $is_lock = $this->_conn->setnx($this->_bucket_lock, $this->get_milli_timestamp()+$this->_bucket_lock_timeout);
            }
        }
        
        return $is_lock? true : false;
    }
    
    /**
     * 释放锁
     *
     * @return Boolean
     */
    private function unlock(){
        return $this->_conn->del($this->_bucket_lock);
    }
    
    /**
     * 获取毫秒级时间戳
     *
     * @return Int
     */
    private function get_milli_timestamp(){
        list($usec, $sec) = explode(' ', microtime());
        $milli_timestamp = $sec . str_pad((int)(($usec * 1000)), 3, '0', STR_PAD_LEFT);
        return $milli_timestamp;
    }
    
    /**
     * 返回数据
     *
     * @param  Int   $error 错误码
     * @param  Array $data  返回数据
     * @return Array
     */
    private function ret_data($error, $data=array()){
        $ret = array(
            'error' => $error,
            'data' => $data,
        );
        
        return $ret;
    }

    /**
     * 创建redis连接
     * @return Link
     */
    private function connect(){
        try{
            $redis = new Redis();
            $redis->connect($this->_config['host'],$this->_config['port'],$this->_config['timeout'],$this->_config['reserved'],$this->_config['retry_interval']);
            if(empty($this->_config['auth'])){
                $redis->auth($this->_config['auth']);
            }
            $redis->select($this->_config['index']);
        }catch(RedisException $e){
            throw new Exception($e->getMessage());
            return false;
        }
        return $redis;
    }
    
} // class end
?>