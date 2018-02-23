<?php
/**
 * PHP基于Redis使用令牌桶算法实现流量控制
 * Date:    2018-02-23
 * Author:  fdipzone
 * Version: 1.0
 *
 * Descripton:
 * php基于Redis使用令牌桶算法实现流量控制，使用redis的队列作为令牌桶容器，入队（lPush）出队（rPop)作为令牌的加入与消耗操作。
 *
 * Func:
 * public  add     加入令牌
 * public  get     获取令牌
 * public  reset   重设令牌桶
 * private connect 创建redis连接
 */
class TrafficShaper{ // class start

    private $_config; // redis设定
    private $_redis;  // redis对象
    private $_queue;  // 令牌桶
    private $_max;    // 最大令牌数

    /**
     * 初始化
     * @param Array $config redis连接设定
     */
    public function __construct($config, $queue, $max){
        $this->_config = $config;
        $this->_queue = $queue;
        $this->_max = $max;
        $this->_redis = $this->connect();
    }

    /**
     * 加入令牌
     * @param  Int $num 加入的令牌数量
     * @return Int 加入的数量
     */
    public function add($num=0){
        
        // 当前剩余令牌数
        $curnum = intval($this->_redis->lSize($this->_queue));
        
        // 最大令牌数
        $maxnum = intval($this->_max);
        
        // 计算最大可加入的令牌数量，不能超过最大令牌数
        $num = $maxnum>=$curnum+$num? $num : $maxnum-$curnum;

        // 加入令牌
        if($num>0){
            $token = array_fill(0, $num, 1);
            $this->_redis->lPush($this->_queue, ...$token);
            return $num;
        }

        return 0;
    
    }

    /**
     * 获取令牌
     * @return Boolean
     */
    public function get(){
        return $this->_redis->rPop($this->_queue)? true : false;
    }

    /**
     * 重设令牌桶，填满令牌
     */
    public function reset(){
        $this->_redis->delete($this->_queue);
        $this->add($this->_max);
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