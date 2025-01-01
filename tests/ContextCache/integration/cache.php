<?php
require dirname(dirname(dirname(dirname(__FILE__)))).'/vendor/autoload.php';

/**
 * 模拟调用第三方系统获取数据，使用 ContextCache 缓存返回数据
 * 避免同一个请求中多次调用第三方系统
 */

// 定义本地系统
class LocalService
{
    // 调用第三方系统获取时间信息
    public function timeInfo():string
    {
        $thirdPartyClient = new ThirdPartyClient;
        $info = $thirdPartyClient->getInfo();
        return isset($info['time'])? date('Y-m-d H:i:s', $info['time']) : '';
    }

    // 调用第三方系统获取随机数信息
    public function randomNumInfo():int
    {
        $thirdPartyClient = new ThirdPartyClient;
        $info = $thirdPartyClient->getInfo();
        return isset($info['random_num'])? $info['random_num'] : 0;
    }
}

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

// 执行
$o = new LocalService;

// 调用多次，返回一样的数据
for($i=0; $i<5; $i++)
{
    printf("time: %s\n", $o->timeInfo());
    printf("random num: %d\n", $o->randomNumInfo());
    sleep(1);
}

$context_cache = \ContextCache\Cache::getInstance();

// 移除 third-party-info 缓存
$context_cache->remove('third-party-info');

// 清空这次请求所有缓存
$context_cache->clear();
