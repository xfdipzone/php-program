<?php declare(strict_types=1);
namespace Tests\DEQue;

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-deque\DEQue\Response
 *
 * @author fdipzone
 */
final class ResponseTest extends TestCase
{
    /**
     * @covers \DEQue\Response::__construct
     * @covers \DEQue\Response::error
     * @covers \DEQue\Response::errMsg
     * @covers \DEQue\Response::item
     */
    public function testResponse()
    {
        $response = new \DEQue\Response(\DEQue\ErrCode::EMPTY, null);
        $this->assertEquals(\DEQue\ErrCode::EMPTY, $response->error());
        $this->assertEquals('队列为空', $response->errMsg());
        $this->assertEquals(null, $response->item());

        $item = new \DEQue\Item('abc');
        $response = new \DEQue\Response(0, $item);
        $this->assertEquals(0, $response->error());
        $this->assertEquals('', $response->errMsg());
        $this->assertEquals('abc', $response->item()->data());
    }
}