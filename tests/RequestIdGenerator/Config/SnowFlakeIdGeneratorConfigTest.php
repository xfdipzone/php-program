<?php declare(strict_types=1);
namespace Tests\RequestIdGenerator\Config;

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-request-id-generator\RequestIdGenerator\Config\SnowFlakeIdGeneratorConfig
 *
 * @author fdipzone
 */
final class SnowFlakeIdGeneratorConfigTest extends TestCase
{
    /**
     * @covers \RequestIdGenerator\Config\SnowFlakeIdGeneratorConfig::__construct
     */
    public function testConstruct()
    {
        $config = new \RequestIdGenerator\Config\SnowFlakeIdGeneratorConfig(1, 1);
        $this->assertEquals('RequestIdGenerator\Config\SnowFlakeIdGeneratorConfig', get_class($config));
    }

    /**
     * @covers \RequestIdGenerator\Config\SnowFlakeIdGeneratorConfig::dataCenterId
     * @covers \RequestIdGenerator\Config\SnowFlakeIdGeneratorConfig::workerId
     */
    public function testGet()
    {
        $config = new \RequestIdGenerator\Config\SnowFlakeIdGeneratorConfig(1, 10);
        $this->assertSame(1, $config->dataCenterId());
        $this->assertSame(10, $config->workerId());
    }
}