<?php
namespace Captcha\Storage;

/**
 * Session存储配置类
 *
 * @author fdipzone
 * @DateTime 2023-05-20 23:56:10
 *
 */
class SessionStorageConfig implements IStorageConfig{

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
        // 检查expire
        if(isset($config['expire']) && is_int($config['expire']) && $config['expire']>0){
            $this->expire = $config['expire'];
        }else{
            throw new \Exception('expire error');
        }
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