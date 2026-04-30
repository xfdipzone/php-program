<?php declare(strict_types=1);
namespace Tests\RequestIdGenerator;

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-request-id-generator\RequestIdGenerator\RandomIdGenerator
 *
 * @author fdipzone
 */
final class RandomIdGeneratorTest extends TestCase
{
    /**
     * @covers \RequestIdGenerator\RandomIdGenerator::generate
     */
    public function testGenerate()
    {
        $random_generator = new \RequestIdGenerator\RandomIdGenerator;
        $request_id = $random_generator->generate();
        $this->assertSame(36, strlen($request_id));
    }

    /**
     * @covers \RequestIdGenerator\RandomIdGenerator::formatResponse
     */
    public function testFormatResponse()
    {
        $test_cases = [
            [
                'request_id' => '3E2598D1C1872444A515DBA5C04C8407',
                'format' => '8,4,4,4,12',
                'expected' => '3E2598D1-C187-2444-A515-DBA5C04C8407'
            ],
            [
                'request_id' => '3E2598D1C1872444A515DBA5C04C8407',
                'format' => '4,4,4,4,4,4',
                'expected' => '3E25-98D1-C187-2444-A515-DBA5-C04C8407'
            ],
            [
                'request_id' => '3E2598D1C1872444A515DBA5C04C8407',
                'format' => '4,4,12',
                'expected' => '3E25-98D1-C1872444A515-DBA5C04C8407'
            ],
            [
                'request_id' => 'ABCDEFGH',
                'format' => '10,2',
                'expected' => 'ABCDEFGH'
            ],
        ];

        $random_generator = new \RequestIdGenerator\RandomIdGenerator;

        foreach($test_cases as $tc)
        {
            $request_id = \Tests\Utils\PHPUnitExtension::callMethod($random_generator, 'formatResponse', [$tc['request_id'], $tc['format']]);
            $this->assertEquals($tc['expected'], $request_id);
        }
    }
}