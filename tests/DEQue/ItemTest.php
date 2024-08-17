<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-deque\DEQue\Item
 *
 * @author fdipzone
 */
final class ItemTest extends TestCase
{
    /**
     * @covers \DEQue\Item::__construct
     * @covers \DEQue\Item::data
     */
    public function testConstructAndGet()
    {
        $item = new \DEQue\Item('abc');
        $this->assertEquals('abc', $item->data());
    }

    /**
     * @covers \DEQue\Item::__construct
     */
    public function testConstructException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('queue item data is empty');
        new \DEQue\Item('');
    }
}