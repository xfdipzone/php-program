<?php declare(strict_types=1);
namespace Tests\SensitiveWordFilter\Storage;

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-sensitive-word-filter\SensitiveWordFilter\Storage\MemoryStorage
 *
 * @author fdipzone
 */
final class MemoryStorageTest extends TestCase
{
    /**
     * @covers \SensitiveWordFilter\Storage\MemoryStorage::setResource
     * @covers \SensitiveWordFilter\Storage\MemoryStorage::sensitiveWords
     */
    public function testSetResourceAndGet()
    {
        $sensitive_words1 = ['a', 'b', 'c', 'd'];
        $sensitive_words2 = ['d', 'e', 'f', 'g'];

        $resource1 = new \SensitiveWordFilter\Resource(\SensitiveWordFilter\Resource::MEMORY);
        $resource1->setWords($sensitive_words1);

        $resource2 = new \SensitiveWordFilter\Resource(\SensitiveWordFilter\Resource::MEMORY);
        $resource2->setWords($sensitive_words2);

        $memory_storage = new \SensitiveWordFilter\Storage\MemoryStorage;
        $memory_storage->setResource($resource1);
        $memory_storage->setResource($resource2);

        $sensitive_words = $memory_storage->sensitiveWords();
        $this->assertEquals(7, count($sensitive_words));
        $this->assertEquals('a,b,c,d,e,f,g', implode(',', $sensitive_words));
    }

    /**
     * @covers \SensitiveWordFilter\Storage\MemoryStorage::setResource
     */
    public function testSetResourceTypeNotMatchException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('memory storage: resource type not match');

        $resource = new \SensitiveWordFilter\Resource(\SensitiveWordFilter\Resource::FILE);

        $memory_storage = new \SensitiveWordFilter\Storage\MemoryStorage;
        $memory_storage->setResource($resource);
    }

    /**
     * @covers \SensitiveWordFilter\Storage\MemoryStorage::setResource
     */
    public function testSetResourceException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('memory storage: sensitive words is empty');

        $resource = new \SensitiveWordFilter\Resource(\SensitiveWordFilter\Resource::MEMORY);

        $memory_storage = new \SensitiveWordFilter\Storage\MemoryStorage;
        $memory_storage->setResource($resource);
    }
}