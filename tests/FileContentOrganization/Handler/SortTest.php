<?php declare(strict_types=1);
namespace Tests\FileContentOrganization\Handler;

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-file-content-organization\FileContentOrganization\Handler\Sort
 *
 * @author fdipzone
 */
final class SortTest extends TestCase
{
    /**
     * @covers \FileContentOrganization\Handler\Sort::setOrder
     * @covers \FileContentOrganization\Handler\Sort::order
     */
    public function testOrder()
    {
        $sort = new \FileContentOrganization\Handler\Sort;

        $sort->setOrder(\FileContentOrganization\Handler\Sort::ORDER_ASC);
        $this->assertEquals(\FileContentOrganization\Handler\Sort::ORDER_ASC, $sort->order());

        $sort->setOrder(\FileContentOrganization\Handler\Sort::ORDER_ASC);
        $this->assertEquals(\FileContentOrganization\Handler\Sort::ORDER_ASC, $sort->order());
    }

    /**
     * @covers \FileContentOrganization\Handler\Sort::setOrder
     */
    public function testSetOrderException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('order must be asc or desc');

        $sort = new \FileContentOrganization\Handler\Sort;
        $sort->setOrder('not_exists_order');
    }

    /**
     * @covers \FileContentOrganization\Handler\Sort::setSortType
     * @covers \FileContentOrganization\Handler\Sort::sortType
     */
    public function testSortType()
    {
        $sort = new \FileContentOrganization\Handler\Sort;

        $sort->setSortType(\FileContentOrganization\Handler\Sort::SORT_TYPE_NUMERIC);
        $this->assertEquals(\FileContentOrganization\Handler\Sort::SORT_TYPE_NUMERIC, $sort->sortType());

        $sort->setSortType(\FileContentOrganization\Handler\Sort::SORT_TYPE_STRING);
        $this->assertEquals(\FileContentOrganization\Handler\Sort::SORT_TYPE_STRING, $sort->sortType());
    }

    /**
     * @covers \FileContentOrganization\Handler\Sort::setSortType
     */
    public function testSetSortTypeException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('sort_type must be SORT_NUMERIC or SORT_STRING sorting type types');

        $sort = new \FileContentOrganization\Handler\Sort;
        $sort->setSortType(9);
    }

    /**
     * @covers \FileContentOrganization\Handler\Sort::handle
     */
    public function testHandle()
    {
        $source = file_get_contents(dirname(dirname(__FILE__)) . '/test_data/source.txt');

        $sort = new \FileContentOrganization\Handler\Sort;

        // 测试 asc + number
        $sort->setOrder(\FileContentOrganization\Handler\Sort::ORDER_ASC);
        $sort->setSortType(\FileContentOrganization\Handler\Sort::SORT_TYPE_NUMERIC);

        $expected = implode(PHP_EOL, ['0', '0', '2', '3', '4', '4', '5', '6', '7', '8', '9', '9', '10', '11', '12', '20']);
        $result = $sort->handle($source);
        $this->assertEquals($expected, $result);

        // 测试 asc + string
        $sort->setOrder(\FileContentOrganization\Handler\Sort::ORDER_ASC);
        $sort->setSortType(\FileContentOrganization\Handler\Sort::SORT_TYPE_STRING);

        $expected = implode(PHP_EOL, ['0', '0', '10', '11', '12', '2', '20', '3', '4', '4', '5', '6', '7', '8', '9', '9']);
        $result = $sort->handle($source);
        $this->assertEquals($expected, $result);

        // 测试 desc + number
        $sort->setOrder(\FileContentOrganization\Handler\Sort::ORDER_DESC);
        $sort->setSortType(\FileContentOrganization\Handler\Sort::SORT_TYPE_NUMERIC);

        $expected = implode(PHP_EOL, ['20', '12', '11', '10', '9', '9', '8', '7', '6', '5', '4', '4', '3', '2', '0', '0']);
        $result = $sort->handle($source);
        $this->assertEquals($expected, $result);

        // 测试 desc + string
        $sort->setOrder(\FileContentOrganization\Handler\Sort::ORDER_DESC);
        $sort->setSortType(\FileContentOrganization\Handler\Sort::SORT_TYPE_STRING);

        $expected = implode(PHP_EOL, ['9', '9', '8', '7', '6', '5', '4', '4', '3', '20', '2', '12', '11', '10', '0', '0']);
        $result = $sort->handle($source);
        $this->assertEquals($expected, $result);
    }
}
