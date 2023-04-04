<?php
namespace Bucket;

/**
 * Redis Bucket 配置类
 *
 * @author fdipzone
 * @DateTime 2023-04-03 23:49:53
 *
 */
class RedisBucketConfig implements IBucketConfig{

    /**
     * bucket组件配置
     *
     * @var array
     */
    private $config = [];

    /**
     * bucket名称
     *
     * @var string
     */
    private $name = '';

    /**
     * 设置bucket组件配置
     *
     * @author fdipzone
     * @DateTime 2023-04-03 23:52:57
     *
     * @param array $config 组件配置
     * @return void
     */
    public function setConfig(array $config):void{
        $this->config = $config;
    }

    /**
     * 获取bucket组件配置
     *
     * @author fdipzone
     * @DateTime 2023-04-03 23:50:30
     *
     * @return array
     */
    public function config():array{
        return $this->config;
    }

    /**
     * 设置bucket名称
     *
     * @author fdipzone
     * @DateTime 2023-04-03 23:54:01
     *
     * @param string $name bucket名称
     * @return void
     */
    public function setName(string $name):void{
        $this->name = $name;
    }

    /**
     * 获取bucket名称
     *
     * @author fdipzone
     * @DateTime 2023-04-03 23:50:45
     *
     * @return string
     */
    public function name():string{
        return $this->name;
    }

}