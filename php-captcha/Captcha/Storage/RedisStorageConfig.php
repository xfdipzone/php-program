<?php
namespace Captcha\Storage;

/**
 * Redis存储配置类
 *
 * @author fdipzone
 * @DateTime 2023-05-21 11:35:23
 *
 */
class RedisStorageConfig implements IStorageConfig{

    /**
     * redis连接配置
     *
     * @var array
     */
    private $connect_config = [];

    /**
     * 存储过期时间（秒）
     *
     * @var int
     */
    private $expire;

    /**
     * 初始化，设置配置
     *
     * @author fdipzone
     * @DateTime 2023-05-21 16:44:05
     *
     * @param array $config 配置
     */
    public function __construct(array $config){
        // 检查 connect_config
        if(isset($config['connect_config']) && is_array($config['connect_config'])){
            $this->connect_config = $config['connect_config'];
        }else{
            throw new \Exception('connect config error');
        }

        // 检查expire
        if(isset($config['expire']) && is_int($config['expire']) && $config['expire']>0){
            $this->expire = $config['expire'];
        }else{
            throw new \Exception('expire error');
        }
    }

    /**
     * 获取redis连接配置
     *
     * @author fdipzone
     * @DateTime 2023-05-21 16:48:21
     *
     * @return array
     */
    public function connectConfig():array{
        return $this->connect_config;
    }

    /**
     * 获取存储过期时间（秒）
     *
     * @author fdipzone
     * @DateTime 2023-05-21 16:48:39
     *
     * @return int
     */
    public function expire():int{
        return $this->expire;
    }

}