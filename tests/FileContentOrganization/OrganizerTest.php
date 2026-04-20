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
    private static $dest = '/tmp/file_content_organization_dest.txt';

    /**
     * @covers \FileContentOrganization\Organizer::__construct
     */
    public function testConstruct()
    {
        $organizer = new \FileContentOrganization\Organizer(self::$source, self::$dest);
        $this->assertEquals(self::$source, \Tests\Utils\PHPUnitExtension::getVariable($organizer, 'source'));
        $this->assertEquals(self::$dest, \Tests\Utils\PHPUnitExtension::getVariable($organizer, 'dest'));
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
                    $dest = self::$dest;
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
                    $dest = self::$dest;
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
        $organizer = new \FileContentOrganization\Organizer(self::$source, self::$dest);

        $sort = \FileContentOrganization\Factory::make(\FileContentOrganization\Type::SORT);
        $unique = \FileContentOrganization\Factory::make(\FileContentOrganization\Type::UNIQUE);

        $organizer->addHandler($sort);
        $organizer->addHandler($unique);

        $handlers = \Tests\Utils\PHPUnitExtension::getVariable($organizer, 'handlers');
        $this->assertSame(2, count($handlers));
        $this->assertEquals('FileContentOrganization\Handler\Sort', get_class($handlers[0]));
        $this->assertEquals('FileContentOrganization\Handler\Unique', get_class($handlers[1]));
    }

    /**
     * @covers \FileContentOrganization\Organizer::handle
     */
    public function testHandle()
    {
        $organizer = new \FileContentOrganization\Organizer(self::$source, self::$dest);

        /** @var \FileContentOrganization\Handler\Sort $sort */
        $sort = \FileContentOrganization\Factory::make(\FileContentOrganization\Type::SORT);
        $sort->setOrder('desc');
        $sort->setSortType(SORT_NUMERIC);

        $unique = \FileContentOrganization\Factory::make(\FileContentOrganization\Type::UNIQUE);

        $organizer->addHandler($sort);
        $organizer->addHandler($unique);

        $this->assertSame(true, $organizer->handle());

        $expected = implode(PHP_EOL, ['20', '12', '11', '10', '9', '8', '7', '6', '5', '4', '3', '2', '0']);
        $this->assertEquals($expected, file_get_contents(self::$dest));
    }

    /**
     * @covers \FileContentOrganization\Organizer::handle
     */
    public function testHandleException()
    {
        $exception_message = 'handle exception';

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage($exception_message);

        $organizer = new \FileContentOrganization\Organizer(self::$source, self::$dest);

        // 创建一个执行异常的 handler
        $mock = $this->getMockBuilder('\FileContentOrganization\Handler\Sort')
                     ->onlyMethods(['handle'])
                     ->getMock();

        $mock->expects($this->any())
             ->method('handle')
             ->will($this->throwException(new \Exception($exception_message)));

        /** @var \FileContentOrganization\IHandler $mock */
        $organizer->addHandler($mock);

        $organizer->handle();
    }

    // 清理测试用例设置
    protected function tearDown():void
    {
        if(file_exists(self::$dest))
        {
            unlink(self::$dest);
        }
    }
}