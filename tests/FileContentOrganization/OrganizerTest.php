<?php declare(strict_types=1);
namespace Tests\FileContentOrganization;

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-file-content-organization\FileContentOrganization\Organizer
 *
 * @author fdipzone
 */
final class OrganizerTest extends TestCase
{
    // 定义用例用到的测试文件
    private static $source = __DIR__ . '/test_data/source.txt';

    /**
     * @covers \FileContentOrganization\Organizer::__construct
     */
    public function testConstruct()
    {
        $dest = sprintf('/tmp/file_content_organization_dest_%d.txt', \Tests\Utils\PHPUnitExtension::sequenceId());

        $organizer = new \FileContentOrganization\Organizer(self::$source, $dest);
        $this->assertEquals(self::$source, \Tests\Utils\PHPUnitExtension::getVariable($organizer, 'source'));
        $this->assertEquals($dest, \Tests\Utils\PHPUnitExtension::getVariable($organizer, 'dest'));
    }

    /**
     * construct 异常测试用例集合
     *
     * @return array [Colsure, string]
     */
    public function constructExceptionCases()
    {
        $exception_cases = [
            [
                function()
                {
                    $source = '';
                    $dest = sprintf('/tmp/file_content_organization_dest_%d.txt', \Tests\Utils\PHPUnitExtension::sequenceId());
                    new \FileContentOrganization\Organizer($source, $dest);
                },
                'source not set',
            ],
            [
                function()
                {
                    $source = self::$source;
                    $dest = '';
                    new \FileContentOrganization\Organizer($source, $dest);
                },
                'dest not set',
            ],
            [
                function()
                {
                    $source = '/tmp/not_exists.txt';
                    $dest = sprintf('/tmp/file_content_organization_dest_%d.txt', \Tests\Utils\PHPUnitExtension::sequenceId());
                    new \FileContentOrganization\Organizer($source, $dest);
                },
                'source not exists',
            ],
        ];

        return $exception_cases;
    }

    /**
     * @covers \FileContentOrganization\Organizer::__construct
     * @dataProvider constructExceptionCases
     */
    public function testConstructException(callable $func, string $exception_message)
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage($exception_message);
        $func();
    }

    /**
     * @covers \FileContentOrganization\Organizer::addHandler
     */
    public function testAddHandler()
    {
        $dest = sprintf('/tmp/file_content_organization_dest_%d.txt', \Tests\Utils\PHPUnitExtension::sequenceId());

        $organizer = new \FileContentOrganization\Organizer(self::$source, $dest);

        $sort = \FileContentOrganization\Factory::make(\FileContentOrganization\Type::SORT);
        $unique = \FileContentOrganization\Factory::make(\FileContentOrganization\Type::UNIQUE);

        $organizer->addHandler($sort);
        $organizer->addHandler($unique);

        $handlers = \Tests\Utils\PHPUnitExtension::getVariable($organizer, 'handlers');
        $this->assertSame(2, count($handlers));
        $this->assertEquals('FileContentOrganization\Handler\Sort', get_class($handlers[0]));
        $this->assertEquals('FileContentOrganization\Handler\Unique', get_class($handlers[1]));
    }
}