<?php declare(strict_types=1);
namespace Tests\FileParser;

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-file-parser\FileParser\Factory
 *
 * @author fdipzone
 */
final class FactoryTest extends TestCase
{
    /**
     * @covers \FileParser\Factory::make
     */
    public function testMake()
    {
        // 创建 XML 解析器对象
        $parser = \FileParser\Factory::make(\FileParser\Type::XML);
        $this->assertEquals('FileParser\XmlParser', get_class($parser));
    
        // 创建 XML 解析器对象（单例）
        $parser2 = \FileParser\Factory::make(\FileParser\Type::XML);

        // 检查是否单例
        $this->assertTrue($parser==$parser2);
    }

    /**
     * @covers \FileParser\Factory::make
     */
    public function testMakeException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('file parser factory: type not_exists_type not exists');

        \FileParser\Factory::make('not_exists_type');
    }

    /**
     * @covers \FileParser\Factory::getParserClass
     */
    public function testGetParserClass()
    {
        $class = \FileParser\Factory::getParserClass(\FileParser\Type::XML);
        $this->assertEquals('\FileParser\XmlParser', $class);
    }

    /**
     * @covers \FileParser\Factory::getParserClass
     */
    public function testGetParserClassException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('file parser factory: type not_exists_type not exists');

        \FileParser\Factory::getParserClass('not_exists_type');
    }
}