<?php
/**
 * php 基于Redis实现计数器类
 *
 * @author fdipzone
 * @DateTime 2023-03-27 21:49:29
 *
 * Description:
 * php基于Redis实现自增计数，主要使用redis的incr方法，并发执行时保证计数自增唯一。
 *
 * Func:
 * public  incr    执行自增计数并获取自增后的数值
 * public  get     获取当前计数
 * public  reset   重置计数
 * private connect 创建redis连接
 */
class RedisCounter{

    /**
     * redis连接配置
     *
     * @var array
     */
    private $_config = [];

    /**
     * redis对象
     *
     * @var \Redis
     */
    private $_redis;

    /**
     * 初始化
     *
     * @author fdipzone
     * @DateTime 2023-03-27 21:50:27
     *
     * @param array $config redis连接配置
     */
    public function __construct(array $config){
        $this->_config = $config;
        $this->_redis = $this->connect();
    }

    /**
     * 执行自增计数并获取自增后的数值
     *
     * @author fdipzone
     * @DateTime 2023-03-27 21:52:07
     *
     * @param string $key 保存计数的键值
     * @param int $incr 自增数量，默认为1
     * @return int
     */
    public function incr(string $key, int $incr=1):int{
        return intval($this->_redis->incr($key, $incr));
    }

    /**
     * 获取当前计数
     *
     * @author fdipzone
     * @DateTime 2023-03-27 21:53:20
     *
     * @param string $key 保存计数的键值
     * @return int
     */
    public function get(string $key):int{
        return intval($this->_redis->get($key));
    }

    /**
     * 重置计数
     *
     * @author fdipzone
     * @DateTime 2023-03-27 21:54:03
     *
     * @param string $key 保存计数的健值
     * @return int
     */
    public function reset(string $key):int{
        return $this->_redis->del($key);
    }

    /**
     * 创建redis连接
     *
     * @author fdipzone
     * @DateTime 2023-03-27 21:54:55
     *
     * @return \Redis
     */
    private function connect():\Redis{
        try{
            $redis = new \Redis();
            $redis->connect($this->_config['host'],$this->_config['port'],$this->_config['timeout'],$this->_config['reserved'],$this->_config['retry_interval']);
            if(empty($this->_config['auth'])){
                $redis->auth($this->_config['auth']);
            }
            $redis->select($this->_config['index']);
        }catch(\Throwable $e){
            throw new \Exception($e->getMessage());
        }
        return $redis;
    }

}
?>