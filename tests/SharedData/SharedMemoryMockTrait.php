<?php
namespace Tests\SharedData;

use Tests\SharedData\SharedMemoryMock;

/**
 * 共享内存 Mock Trait
 *
 * 提供共享内存相关测试的 Mock 控制方法
 * 用于模拟 shmop_open、shm_attach 等方法执行异常的场景
 *
 * @author fdipzone
 * @DateTime 2026-08-12 23:13:07
 *
 */
trait SharedMemoryMockTrait
{
    /**
     * 模拟 shmop_open 方法执行异常
     *
     * 启用后，SharedData\shmop_open() 将返回 false
     * 从而触发业务代码中的 shm_id create fail 异常
     *
     * @author fdipzone
     * @DateTime 2026-08-12 23:14:36
     *
     * @return void
     */
    protected function mockShmopOpenException(): void
    {
        SharedMemoryMock::$enable_open_exception = true;
    }

    /**
     * 模拟 shm_attach 方法执行异常
     *
     * 启用后，SharedData\shm_attach() 将返回 false
     * 从而触发业务代码中的 shm_id create fail 异常
     *
     * @author fdipzone
     * @DateTime 2026-08-12 23:14:11
     *
     * @return void
     */
    protected function mockShmAttachException(): void
    {
        SharedMemoryMock::$enable_attach_exception = true;
    }

    /**
     * 重置共享内存 Mock 状态
     *
     * 用于测试结束后恢复 Mock 状态
     * 避免影响其他测试用例
     *
     * @author fdipzone
     * @DateTime 2026-08-12 23:13:51
     *
     * @return void
     */
    protected function resetSharedMemoryMock(): void
    {
        SharedMemoryMock::reset();
    }
}
