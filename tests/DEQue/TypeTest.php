<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-deque\DEQue\Type
 *
 * @author fdipzone
 */
final class TypeTest extends TestCase
{
    /**
     * @covers \DEQue\Type::check
     */
    public function testCheck()
    {
        $ret = \DEQue\Type::check(\DEQue\Type::UNRESTRICTED);
        $this->assertSame(true, $ret);

        $ret = \DEQue\Type::check(\DEQue\Type::FRONT_ONLY_IN);
        $this->assertSame(true, $ret);

        $ret = \DEQue\Type::check(\DEQue\Type::FRONT_ONLY_OUT);
        $this->assertSame(true, $ret);

        $ret = \DEQue\Type::check(\DEQue\Type::REAR_ONLY_IN);
        $this->assertSame(true, $ret);

        $ret = \DEQue\Type::check(\DEQue\Type::REAR_ONLY_OUT);
        $this->assertSame(true, $ret);

        $ret = \DEQue\Type::check(\DEQue\Type::SAME_ENDPOINT);
        $this->assertSame(true, $ret);

        $ret = \DEQue\Type::check(0);
        $this->assertSame(false, $ret);
    }
}