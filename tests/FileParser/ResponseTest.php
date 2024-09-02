<?php declare(strict_types=1);
namespace Tests\FileParser;

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-file-parser\FileParser\Response
 *
 * @author fdipzone
 */
final class ResponseTest extends TestCase
{
    /**
     * @covers \FileParser\Response::__construct
     * @covers \FileParser\Response::status
     * @covers \FileParser\Response::data
     */
    public function testConstructAndGet()
    {
        $status = true;
        $data = array('name'=>'fdipzone');
        $response = new \FileParser\Response($status, $data);
        $this->assertEquals(get_class($response), 'FileParser\Response');
        $this->assertSame($status, $response->status());
        $this->assertEquals($data['name'], $response->data()['name']);
    }
}