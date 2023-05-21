<?php
namespace Captcha\Storage;

/**
 * 定义Captcha存储类配置接口
 *
 * @author fdipzone
 * @DateTime 2023-05-20 23:40:45
 *
 */
interface IStorageConfig{

    /**
     * 获取存储过期时间（秒）
     *
     * @author fdipzone
     * @DateTime 2023-05-21 16:40:06
     *
     * @return int
     */
    public function expire():int;

}