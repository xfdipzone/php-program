<?php
/**
 * php 基于Redis使用令牌桶算法实现流量控制
 *
 * @author fdipzone
 * @DateTime 2023-03-28 14:58:33
 *
* Description:
 * php基于Redis使用令牌桶算法实现流量控制，使用redis的队列作为令牌桶容器，入队（lPush）出队（rPop)作为令牌的加入与消耗操作。
 *
 * Func:
 * public  add     加入令牌
 * public  get     获取令牌
 * public  reset   重设令牌桶
 * private connect 创建redis连接
 */
class TrafficShaper{

    /**
     * redis连接设定
     *
     * @var array
     */
    private $_config;

    /**
     * redis对象
     *
     * @var \Redis
     */
    private $_redis;

    /**
     * 令牌桶名称
     *
     * @var string
     */
    private $_queue;

    /**
     * 最大令牌数
     *
     * @var int
     */
    private $_max;

    /**
     * 初始化
     *
     * @author fdipzone
     * @DateTime 2023-03-28 16:12:13
     *
     * @param array $config redis连接设定
     * @param string $queue 令牌桶名称
     * @param int $max 最大令牌数
     */
    public function __construct(array $config, string $queue, int $max){
        $this->_config = $config;
        $this->_queue = $queue;
        $this->_max = $max;
        $this->_redis = $this->connect();
    }

    /**
     * 加入令牌
     *
     * @author fdipzone
     * @DateTime 2023-03-28 16:17:29
     *
     * @param int $num 加入的令牌数量
     * @return int
     */
    public function add(int $num=0):int{

        // 当前剩余令牌数
        $cur_num = intval($this->_redis->lSize($this->_queue));

        // 最大令牌数
        $max_num = intval($this->_max);

        // 计算最大可加入的令牌数量，不能超过最大令牌数
        $num = $max_num>=$cur_num+$num? $num : $max_num-$cur_num;

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
     *
     * @author fdipzone
     * @DateTime 2023-03-28 16:19:07
     *
     * @return boolean
     */
    public function get():bool{
        return $this->_redis->rPop($this->_queue)? true : false;
    }

    /**
     * 重设令牌桶，填满令牌
     *
     * @author fdipzone
     * @DateTime 2023-03-28 16:20:04
     *
     * @return void
     */
    public function reset():void{
        $this->_redis->delete($this->_queue);
        $this->add($this->_max);
    }

    /**
     * 创建redis连接
     *
     * @author fdipzone
     * @DateTime 2023-03-28 17:37:57
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
            return false;
        }
        return $redis;
    }

}
?>