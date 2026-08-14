<?php
namespace Tests\SharedData;

/**
 * 共享内存 Mock 标记类
 *
 * @author fdipzone
 * @DateTime 2026-08-11 22:00:20
 */
class SharedMemoryMock
{
    /**
     * 标记 shmop_open 异常状态
     *
     * @var boolean
     */
    public static bool $enable_open_exception = false;

    /**
     * 标记 shm_attach 异常状态
     *
     * @var boolean
     */
    public static bool $enable_attach_exception = false;

    /**
     * 重置标记
     *
     * @author fdipzone
     * @DateTime 2026-08-11 22:14:05
     *
     * @return void
     */
    public static function reset():void
    {
        self::$enable_open_exception = false;
        self::$enable_attach_exception = false;
    }
}