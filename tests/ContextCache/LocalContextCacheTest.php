<?php declare(strict_types=1);
namespace Tests\ContextCache;

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-context-cache\ContextCache\LocalContextCache
 *
 * @author fdipzone
 */
final class LocalContextCacheTest extends TestCase
{
    /**
     * @covers \ContextCache\LocalContextCache::put
     * @covers \ContextCache\LocalContextCache::get
     * @covers \ContextCache\LocalContextCache::remove
     * @covers \ContextCache\LocalContextCache::clear
     */
    public function testCache()
    {
        $key = 'name';
        $value = 'fdipzone';

        $local_context_cache = new \ContextCache\LocalContextCache;

        // 测试设置缓存
        $ret = $local_context_cache->put($key, $value);
        $this->assertTrue($ret);

        // 测试获取缓存
        $data = $local_context_cache->get($key);
        $this->assertEquals($value, $data);

        // 测试获取不存在的缓存
        $data = $local_context_cache->get('not_exists_key');
        $this->assertNull($data);

        // 测试移除缓存
        $ret = $local_context_cache->remove($key);
        $this->assertTrue($ret);

        // 测试移除不存在的缓存
        $ret = $local_context_cache->remove('not_exists_key');
        $this->assertFalse($ret);

        // 测试清空所有缓存
        $local_context_cache->put($key, $value);
        $this->assertSame(1, count(\Tests\Utils\PHPUnitExtension::getVariable($local_context_cache, 'cache')));

        $local_context_cache->clear();
        $this->assertSame(0, count(\Tests\Utils\PHPUnitExtension::getVariable($local_context_cache, 'cache')));
    }
}