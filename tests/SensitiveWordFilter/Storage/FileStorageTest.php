<?php declare(strict_types=1);
namespace Tests\SensitiveWordFilter\Storage;

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-sensitive-word-filter\SensitiveWordFilter\Storage\FileStorage
 *
 * @author fdipzone
 */
final class FileStorageTest extends TestCase
{
    // 定义用例用到的测试文件
    private static $sensitive_words_file1 = '/tmp/sensitive_words1.txt';
    private static $sensitive_words_file2 = '/tmp/sensitive_words2.txt';

    // 初始化测试文件
    public static function setUpBeforeClass()
    {
        file_put_contents(self::$sensitive_words_file1, implode(PHP_EOL, ['a', 'b', 'c', 'd']));
        file_put_contents(self::$sensitive_words_file2, implode(PHP_EOL, ['d', 'e', 'f', 'g']), FILE_APPEND);
    }

    // 删除测试文件
    public static function tearDownAfterClass()
    {
        if(file_exists(self::$sensitive_words_file1))
        {
            unlink(self::$sensitive_words_file1);
        }

        if(file_exists(self::$sensitive_words_file2))
        {
            unlink(self::$sensitive_words_file2);
        }
    }

    /**
     * @covers \SensitiveWordFilter\Storage\FileStorage::setResource
     * @covers \SensitiveWordFilter\Storage\FileStorage::sensitiveWords
     */
    public function testSetResourceAndGet()
    {
        $resource1 = new \SensitiveWordFilter\Resource(\SensitiveWordFilter\Resource::FILE);
        $resource1->setFile(self::$sensitive_words_file1);

        $resource2 = new \SensitiveWordFilter\Resource(\SensitiveWordFilter\Resource::FILE);
        $resource2->setFile(self::$sensitive_words_file2);

        $memory_storage = new \SensitiveWordFilter\Storage\FileStorage;
        $memory_storage->setResource($resource1);
        $memory_storage->setResource($resource2);

        $sensitive_words = $memory_storage->sensitiveWords();
        $this->assertEquals(7, count($sensitive_words));
        $this->assertEquals('a,b,c,d,e,f,g', implode(',', $sensitive_words));
    }

    /**
     * @covers \SensitiveWordFilter\Storage\FileStorage::parseSensitiveWordFile
     */
    public function testParseSensitiveWordFile()
    {
        $memory_storage = new \SensitiveWordFilter\Storage\FileStorage;
        $sensitive_words = \Tests\Utils\PHPUnitExtension::callMethod($memory_storage, 'parseSensitiveWordFile', [self::$sensitive_words_file1]);
        $this->assertEquals(4, count($sensitive_words));
        $this->assertEquals('a,b,c,d', implode(',', array_keys($sensitive_words)));
    }

    /**
     * @covers \SensitiveWordFilter\Storage\FileStorage::setResource
     */
    public function testSetResourceTypeNotMatchException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('file storage: resource type not match');

        $resource = new \SensitiveWordFilter\Resource(\SensitiveWordFilter\Resource::MEMORY);

        $memory_storage = new \SensitiveWordFilter\Storage\FileStorage;
        $memory_storage->setResource($resource);
    }

    /**
     * @covers \SensitiveWordFilter\Storage\FileStorage::setResource
     */
    public function testSetResourceException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('file storage: sensitive word file not exists');

        $resource = new \SensitiveWordFilter\Resource(\SensitiveWordFilter\Resource::FILE);

        $memory_storage = new \SensitiveWordFilter\Storage\FileStorage;
        $memory_storage->setResource($resource);
    }
}