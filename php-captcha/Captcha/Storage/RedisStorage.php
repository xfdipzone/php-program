<?php
namespace Captcha\Storage;

/**
 * 基于Redis存储实现Captcha验证码存储类
 *
 * @author fdipzone
 * @DateTime 2023-05-21 11:36:03
 *
 */
class RedisStorage implements IStorage{

    /**
     * 存储配置
     *
     * @var \Captcha\Storage\RedisStorageConfig
     */
    private $config;

    /**
     * redis连接
     *
     * @var \Redis
     */
    private $conn;

    /**
     * 初始化，设置配置类对象
     *
     * @author fdipzone
     * @DateTime 2023-05-21 12:13:49
     *
     * @param IStorageConfig $config 存储配置对象
     */
    public function __construct(IStorageConfig $config){
        if(get_class($config)!='Captcha\Storage\RedisStorageConfig'){
            throw new \Exception('config type error');
        }
        $this->config = $config;
        $this->conn = $this->connect();
    }

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
    public function save(string $key, string $data):bool{
        return (bool)($this->conn->set($key, $data, $this->config->expire()));
    }

    /**
     * 获取数据
     *
     * @author fdipzone
     * @DateTime 2023-05-21 11:50:41
     *
     * @param string $key 标识
     * @return string
     */
    public function get(string $key):string{
        return (string)($this->conn->get($key));
    }

    /**
     * 删除存储的数据
     *
     * @author fdipzone
     * @DateTime 2023-05-21 11:50:54
     *
     * @param string $key 标识
     * @return boolean
     */
    public function delete(string $key):bool{
        return (bool)($this->conn->del($key));
    }

    /**
     * 创建redis连接
     *
     * @author fdipzone
     * @DateTime 2023-05-21 19:28:40
     *
     * @return \Redis
     */
    private function connect(): \Redis{
        $connect_config = $this->config->connectConfig();

        try {
            $redis = new \Redis();
            $redis->connect($connect_config['host'], $connect_config['port'], $connect_config['timeout'], $connect_config['reserved'], $connect_config['retry_interval']);
            if (empty($connect_config['auth'])) {
                $redis->auth($connect_config['auth']);
            }
            $redis->select($connect_config['index']);
        } catch (\Throwable $e) {
            throw new \Exception($e->getMessage());
        }

        return $redis;
    }

}