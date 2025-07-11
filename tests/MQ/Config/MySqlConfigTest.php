<?php declare(strict_types=1);
namespace Tests\MQ;

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-mq\MQ\Config\MySqlConfig
 *
 * @author fdipzone
 */
final class MySqlConfigTest extends TestCase
{
    /**
     * @covers \MQ\Config\MySqlConfig
     */
    public function testConstruct()
    {
        $config = new \MQ\Config\MySqlConfig;
        $this->assertEquals('MQ\Config\MySqlConfig', get_class($config));
        $this->assertInstanceOf(\MQ\Config\IMessageQueueConfig::class, $config);
    }
}