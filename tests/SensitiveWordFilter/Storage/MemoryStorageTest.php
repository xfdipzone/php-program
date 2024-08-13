<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-sensitive-word-filter\SensitiveWordFilter\Storage\MemoryStorage
 *
 * @author fdipzone
 */
final class MemoryStorageTest extends TestCase
{
    /**
     * @covers \SensitiveWordFilter\Storage\MemoryStorage::save
     * @covers \SensitiveWordFilter\Storage\MemoryStorage::sensitiveWords
     */
    public function testSaveAndGet()
    {
        $sensitive_words1 = ['a', 'b', 'c', 'd'];
        $sensitive_words2 = ['d', 'e', 'f', 'g'];
        $memory_storage = new \SensitiveWordFilter\Storage\MemoryStorage;
        $memory_storage->save($sensitive_words1);
        $memory_storage->save($sensitive_words2);

        $sensitive_words = $memory_storage->sensitiveWords();
        $this->assertEquals(7, count($sensitive_words));
        $this->assertEquals('a,b,c,d,e,f,g', implode(',', array_keys($sensitive_words)));
    }

    /**
     * @covers \SensitiveWordFilter\Storage\MemoryStorage::save
     */
    public function testSaveException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('memory storage: sensitive words is empty');
        $memory_storage = new \SensitiveWordFilter\Storage\MemoryStorage;
        $memory_storage->save([]);
    }
}