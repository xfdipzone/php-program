<?php
namespace Bucket;

/**
 * 定义bucket类配置接口
 *
 * @author fdipzone
 * @DateTime 2023-04-03 23:44:22
 *
 */
interface IBucketConfig{

    /**
     * 获取bucket组件配置
     *
     * @author fdipzone
     * @DateTime 2023-04-03 23:45:57
     *
     * @return array
     */
    public function config():array;

    /**
     * 获取bucket名称
     *
     * @author fdipzone
     * @DateTime 2023-04-03 23:49:12
     *
     * @return string
     */
    public function name():string;
}