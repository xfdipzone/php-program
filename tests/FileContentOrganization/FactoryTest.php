<?php declare(strict_types=1);
namespace Tests\FileContentOrganization;

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-file-content-organization\FileContentOrganization\Factory
 *
 * @author fdipzone
 */
final class FactoryTest extends TestCase
{
    /**
     * @covers \FileContentOrganization\Factory::make
     */
    public function testMake()
    {
        $sort_handler = \FileContentOrganization\Factory::make(\FileContentOrganization\Type::SORT);
        $this->assertEquals('FileContentOrganization\Handler\Sort', get_class($sort_handler));

        $unique_handler = \FileContentOrganization\Factory::make(\FileContentOrganization\Type::UNIQUE);
        $this->assertEquals('FileContentOrganization\Handler\Unique', get_class($unique_handler));
    }

    /**
     * @covers \FileContentOrganization\Factory::make
     */
    public function testMakeException()
    {
        $type = 'not_exists_type';
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage(sprintf('%s type handler not exists', $type));

        \FileContentOrganization\Factory::make($type);
    }

    /**
     * @covers \FileContentOrganization\Factory::getHandlerClass
     */
    public function testGetHandlerClass()
    {
        $sort_handler_class = \FileContentOrganization\Factory::getHandlerClass(\FileContentOrganization\Type::SORT);
        $this->assertEquals('\FileContentOrganization\Handler\Sort', $sort_handler_class);

        $unique_handler_class = \FileContentOrganization\Factory::getHandlerClass(\FileContentOrganization\Type::UNIQUE);
        $this->assertEquals('\FileContentOrganization\Handler\Unique', $unique_handler_class);
    }

    /**
     * @covers \FileContentOrganization\Factory::getHandlerClass
     */
    public function testGetHandlerClassException()
    {
        $type = 'not_exists_type';
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage(sprintf('%s type handler not exists', $type));

        \FileContentOrganization\Factory::getHandlerClass($type);
    }
}