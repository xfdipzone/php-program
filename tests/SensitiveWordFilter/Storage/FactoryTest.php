<?php declare(strict_types=1);
namespace Tests\SensitiveWordFilter\Storage;

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-sensitive-word-filter\SensitiveWordFilter\Storage\Factory
 *
 * @author fdipzone
 */
final class FactoryTest extends TestCase
{
    /**
     * @covers \SensitiveWordFilter\Storage\Factory::getStorageClass
     */
    public function testGetStorageClass()
    {
        $class_name = \SensitiveWordFilter\Storage\Factory::getStorageClass(\SensitiveWordFilter\Storage\Type::MEMORY);
        $this->assertEquals($class_name, '\SensitiveWordFilter\Storage\MemoryStorage');

        $class_name = \SensitiveWordFilter\Storage\Factory::getStorageClass(\SensitiveWordFilter\Storage\Type::FILE);
        $this->assertEquals($class_name, '\SensitiveWordFilter\Storage\FileStorage');
    }

    /**
     * @covers \SensitiveWordFilter\Storage\Factory::getStorageClass
     */
    public function testGetStorageClassException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('storage factory: type not_exists_type not exists');
        $type = 'not_exists_type';
        \SensitiveWordFilter\Storage\Factory::getStorageClass($type);
    }

    /**
     * @covers \SensitiveWordFilter\Storage\Factory::make
     */
    public function testMake()
    {
        $storage = \SensitiveWordFilter\Storage\Factory::make(\SensitiveWordFilter\Storage\Type::MEMORY);
        $this->assertEquals('SensitiveWordFilter\Storage\MemoryStorage', get_class($storage));

        $storage = \SensitiveWordFilter\Storage\Factory::make(\SensitiveWordFilter\Storage\Type::FILE);
        $this->assertEquals('SensitiveWordFilter\Storage\FileStorage', get_class($storage));
    }

    /**
     * @covers \SensitiveWordFilter\Storage\Factory::make
     */
    public function testMakeException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('storage factory: type not_exists_type not exists');
        $type = 'not_exists_type';
        \SensitiveWordFilter\Storage\Factory::make($type);
    }
}