<?php declare(strict_types=1);
namespace Tests\MQ;

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-mq\MQ\Factory
 *
 * @author fdipzone
 */
final class FactoryTest extends TestCase
{
    /**
     * @covers \MQ\Factory::getMQClass
     */
    public function testGetMQClass()
    {
        $type = \MQ\Type::MYSQL;
        $mq_class = \MQ\Factory::getMQClass($type);
        $this->assertEquals('\MQ\MySQL\MySqlMessageQueue', $mq_class);
    }

    /**
     * @covers \MQ\Factory::getMQClass
     */
    public function testGetMQClassException()
    {
        $this->expectException(\MQ\Exception\TypeException::class);
        $this->expectExceptionMessage('not_exists type not exists');

        $type = 'not_exists';
        \MQ\Factory::getMQClass($type);
    }

    /**
     * @covers \MQ\Factory::make
     */
    public function testMake()
    {
        $type = \MQ\Type::MYSQL;
        $config = new \MQ\Config\MySqlConfig;
        $mq = \MQ\Factory::make($type, $config);
        $this->assertEquals('MQ\MySQL\MySqlMessageQueue', get_class($mq));
        $this->assertInstanceOf(\MQ\IMessageQueue::class, $mq);
    }

    /**
     * @covers \MQ\Factory::make
     */
    public function testMakeException()
    {
        $this->expectException(\MQ\Exception\FactoryException::class);
        $this->expectExceptionMessage('not_exists type not exists');

        $type = 'not_exists';
        $config = new \MQ\Config\MySqlConfig;
        \MQ\Factory::make($type, $config);
    }
}