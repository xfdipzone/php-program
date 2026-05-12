<?php declare(strict_types=1);
namespace Tests\RequestIdGenerator;

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-request-id-generator\RequestIdGenerator\Factory
 *
 * @author fdipzone
 */
final class FactoryTest extends TestCase
{
    /**
     * @covers \RequestIdGenerator\Factory::getGeneratorClass
     */
    public function testGetGeneratorClass()
    {
        // RandomIdGenerator class
        $type = \RequestIdGenerator\Type::RANDOM;
        $generator_class = \RequestIdGenerator\Factory::getGeneratorClass($type);
        $this->assertEquals('\RequestIdGenerator\RandomIdGenerator', $generator_class);

        // SnowFlakeIdGenerator class
        $type = \RequestIdGenerator\Type::SNOW_FLAKE;
        $generator_class = \RequestIdGenerator\Factory::getGeneratorClass($type);
        $this->assertEquals('\RequestIdGenerator\SnowFlakeIdGenerator', $generator_class);
    }

    /**
     * @covers \RequestIdGenerator\Factory::getGeneratorClass
     */
    public function testGetGeneratorClassException()
    {
        $this->expectException(\RequestIdGenerator\Exception\TypeException::class);
        $this->expectExceptionMessage('not_exists type not exists');

        $type = 'not_exists';
        \RequestIdGenerator\Factory::getGeneratorClass($type);
    }

    /**
     * @covers \RequestIdGenerator\Factory::make
     */
    public function testMake()
    {
        $type = \RequestIdGenerator\Type::RANDOM;
        $generator = \RequestIdGenerator\Factory::make($type);
        $this->assertEquals('RequestIdGenerator\RandomIdGenerator', get_class($generator));
        $this->assertInstanceOf(\RequestIdGenerator\IRequestIdGenerator::class, $generator);
    }

    /**
     * @covers \RequestIdGenerator\Factory::make
     */
    public function testMakeException()
    {
        $this->expectException(\RequestIdGenerator\Exception\FactoryException::class);
        $this->expectExceptionMessage('not_exists type not exists');

        $type = 'not_exists';
        \RequestIdGenerator\Factory::make($type);
    }
}