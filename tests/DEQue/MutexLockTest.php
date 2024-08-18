<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-deque\DEQue\MutexLock
 *
 * @author fdipzone
 */
final class MutexLockTest extends TestCase
{
    /**
     * @covers \DEQue\MutexLock::__construct
     * @covers \DEQue\MutexLock::lock
     */
    public function testLock()
    {
        // 不设置标识
        $mutex = new \DEQue\MutexLock();
        $ret = $mutex->lock();
        $this->assertSame(true, $ret);

        // 设置标识
        $mutex = new \DEQue\MutexLock('abc');
        $ret = $mutex->lock(100);
        $this->assertSame(true, $ret);

        // 可重入
        $ret = $mutex->lock(100);
        $this->assertSame(true, $ret);
    }

    /**
     * @covers \DEQue\MutexLock::__construct
     * @covers \DEQue\MutexLock::unlock
     */
    public function testUnLock()
    {
        // 没加锁，直接调用解锁
        $mutex = new \DEQue\MutexLock();
        $ret = $mutex->unlock();
        $this->assertSame(false, $ret);

        // 加锁后调用解锁
        $mutex = new \DEQue\MutexLock('abc');
        $ret = $mutex->lock(-1);
        $this->assertSame(true, $ret);

        $ret = $mutex->unlock();
        $this->assertSame(true, $ret);

        // 解锁后再调用解锁
        $ret = $mutex->unlock();
        $this->assertSame(false, $ret);
    }
}