<?php
/**
 * PHP基于Redis计数器类
 * Date:    2017-10-28
 * Author:  fdipzone
 * Version: 1.0
 *
 * Descripton:
 * php基于Redis实现自增计数，主要使用redis的incr方法，并发执行时保证计数自增唯一。
 *
 * Func:
 * public  incr    执行自增计数并获取自增后的数值
 * public  get     获取当前计数
 * public  reset   重置计数
 * private connect 创建redis连接
 */
class RedisCounter{ // class start

    private $_config;
    private $_redis;

    /**
     * 初始化
     * @param Array $config redis连接设定
     */
    public function __construct($config){
        $this->_config = $config;
        $this->_redis = $this->connect();
    }

    /**
     * 执行自增计数并获取自增后的数值
     * @param  String $key  保存计数的键值
     * @param  Int    $incr 自增数量，默认为1
     * @return Int
     */
    public function incr($key, $incr=1){
        return intval($this->_redis->incr($key, $incr));
    }

    /**
     * 获取当前计数
     * @param  String $key 保存计数的健值
     * @return Int
     */
    public function get($key){
        return intval($this->_redis->get($key));
    }

    /**
     * 重置计数
     * @param  String  $key 保存计数的健值
     * @return Int
     */
    public function reset($key){
        return $this->_redis->delete($key);
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