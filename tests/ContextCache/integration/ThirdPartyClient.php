<?php
namespace Tests\ContextCache\integration;

// 定义第三方系统客户端
class ThirdPartyClient
{
    // 调用第三方系统接口获取信息
    public function getInfo():array
    {
        // 读取上下文缓存
        $context_cache = \ContextCache\Cache::getInstance();
        $cache_key = 'third-party-info';
        $info = $context_cache->get($cache_key);

        if(is_null($info))
        {
            // 模拟调用第三方获取数据，此处用当前时间戳+随机数代替
            $info = array(
                'time' => time(),
                'random_num' => mt_rand(100000, 999999)
            );

            // 设置上下文缓存
            $context_cache->put($cache_key, $info);
        }

        return $info;
    }
}
