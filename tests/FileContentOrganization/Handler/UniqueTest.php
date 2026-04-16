<?php declare(strict_types=1);
namespace Tests\FileContentOrganization\Handler;

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-file-content-organization\FileContentOrganization\Handler\Unique
 *
 * @author fdipzone
 */
final class UniqueTest extends TestCase
{
    /**
     * @covers \FileContentOrganization\Handler\Unique::handle
     */
    public function testHandle()
    {
        $source = file_get_contents(dirname(dirname(__FILE__)) . '/test_data/source.txt');

        $unique = new \FileContentOrganization\Handler\Unique;
        $expected = implode(PHP_EOL, ['0', '4', '10', '2', '9', '3', '11', '8', '5', '6', '12', '7', '20']);
        $result = $unique->handle($source);
        $this->assertEquals($expected, $result);
    }
}
