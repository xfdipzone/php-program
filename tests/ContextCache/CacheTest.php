<?php declare(strict_types=1);
namespace Tests\ContextCache;

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-context-cache\ContextCache\Cache
 *
 * @author fdipzone
 */
final class CacheTest extends TestCase
{
    /**
     * @covers \ContextCache\Cache::getCacheClass
     */
    public function testGetCacheClass()
    {
        $type = \ContextCache\Type::LOCAL;
        $class = \ContextCache\Cache::getCacheClass($type);
        $this->assertEquals('\ContextCache\LocalContextCache', $class);
    }

    /**
     * @covers \ContextCache\Cache::getCacheClass
     */
    public function testGetCacheClassException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage(sprintf('%s type cache not exists', 'not_exists_type'));

        $type = 'not_exists_type';
        \ContextCache\Cache::getCacheClass($type);
    }

    /**
     * @covers \ContextCache\Cache::getInstance
     */
    public function testGetInstance()
    {
        $type = \ContextCache\Type::LOCAL;
        $context_cache = \ContextCache\Cache::getInstance($type);
        $this->assertEquals('ContextCache\LocalContextCache', get_class($context_cache));

        // 测试单例
        $context_cache2 = \ContextCache\Cache::getInstance($type);
        $this->assertSame($context_cache, $context_cache2);
    }

    /**
     * @covers \ContextCache\Cache::getInstance
     */
    public function testGetInstanceException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage(sprintf('%s type cache not exists', 'not_exists_type'));

        $type = 'not_exists_type';
        \ContextCache\Cache::getInstance($type);
    }
}