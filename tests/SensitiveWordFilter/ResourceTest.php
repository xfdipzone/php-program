<?php declare(strict_types=1);
namespace Tests\SensitiveWordFilter;

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-sensitive-word-filter\SensitiveWordFilter\Resource
 *
 * @author fdipzone
 */
final class ResourceTest extends TestCase
{
    /**
     * @covers \SensitiveWordFilter\Resource::__construct
     */
    public function testConstruct()
    {
        $resource = new \SensitiveWordFilter\Resource(\SensitiveWordFilter\Resource::MEMORY);
        $this->assertEquals(get_class($resource), 'SensitiveWordFilter\Resource');
    }

    /**
     * @covers \SensitiveWordFilter\Resource::__construct
     */
    public function testConstructException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('resource: type not_exists_type not exists');
        $type = 'not_exists_type';
        new \SensitiveWordFilter\Resource($type);
    }

    /**
     * @covers \SensitiveWordFilter\Resource::type
     */
    public function testType()
    {
        $resource = new \SensitiveWordFilter\Resource(\SensitiveWordFilter\Resource::MEMORY);
        $this->assertEquals(\SensitiveWordFilter\Resource::MEMORY, $resource->type());
    }

    /**
     * @covers \SensitiveWordFilter\Resource::setWords
     * @covers \SensitiveWordFilter\Resource::getWords
     */
    public function testSetAndGetWords()
    {
        $resource = new \SensitiveWordFilter\Resource(\SensitiveWordFilter\Resource::MEMORY);
        $resource->setWords(['a', 'b', 'c']);
        $words = $resource->getWords();
        $this->assertEquals('a,b,c', implode(',', $words));
    }

    /**
     * @covers \SensitiveWordFilter\Resource::setWords
     */
    public function testSetWordsTypeException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('resource: type not match');
        $resource = new \SensitiveWordFilter\Resource(\SensitiveWordFilter\Resource::FILE);
        $resource->setWords(['a', 'b', 'c']);
    }

    /**
     * @covers \SensitiveWordFilter\Resource::setWords
     */
    public function testSetWordsEmptyException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('resource: sensitive words is empty');
        $resource = new \SensitiveWordFilter\Resource(\SensitiveWordFilter\Resource::MEMORY);
        $resource->setWords([]);
    }

    /**
     * @covers \SensitiveWordFilter\Resource::getWords
     */
    public function testGetWordsTypeException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('resource: type not match');
        $resource = new \SensitiveWordFilter\Resource(\SensitiveWordFilter\Resource::FILE);
        $resource->getWords();
    }

    /**
     * @covers \SensitiveWordFilter\Resource::setFile
     * @covers \SensitiveWordFilter\Resource::getFile
     */
    public function testSetAndGetFile()
    {
        $tmp_file = '/tmp/'.time().'txt';
        file_put_contents($tmp_file, 'test');

        $resource = new \SensitiveWordFilter\Resource(\SensitiveWordFilter\Resource::FILE);
        $resource->setFile($tmp_file);
        $file = $resource->getFile();
        $this->assertEquals($tmp_file, $file);

        if(file_exists($tmp_file))
        {
            unlink($tmp_file);
        }
    }

    /**
     * @covers \SensitiveWordFilter\Resource::setFile
     */
    public function testSetFileTypeException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('resource: type not match');
        $resource = new \SensitiveWordFilter\Resource(\SensitiveWordFilter\Resource::MEMORY);
        $resource->setFile('');
    }

    /**
     * @covers \SensitiveWordFilter\Resource::setFile
     */
    public function testSetFileNotExistsException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('resource: sensitive word file not exists');
        $resource = new \SensitiveWordFilter\Resource(\SensitiveWordFilter\Resource::FILE);
        $resource->setFile('/tmp/not_exists_file.txt');
    }

    /**
     * @covers \SensitiveWordFilter\Resource::getFile
     */
    public function testGetFileTypeException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('resource: type not match');
        $resource = new \SensitiveWordFilter\Resource(\SensitiveWordFilter\Resource::MEMORY);
        $resource->getFile();
    }
}