<?php
namespace Tests\ContextCache\integration;

require dirname(dirname(dirname(dirname(__FILE__)))).'/vendor/autoload.php';

/**
 * 模拟调用第三方系统获取数据，使用 ContextCache 缓存返回数据
 * 避免同一个请求中多次调用第三方系统
 */
class CacheDemo
{
    // 执行
    public function run():void
    {
        $o = new \Tests\ContextCache\integration\LocalService;

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
    }
}

$cache = new CacheDemo;
$cache->run();
