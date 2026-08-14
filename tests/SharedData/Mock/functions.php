<?php
namespace SharedData;

use \Tests\SharedData\SharedMemoryMock;

/**
 * mock shmop_open 方法
 *
 * @author fdipzone
 * @DateTime 2026-08-11 22:10:18
 *
 * @param int $key
 * @param string $flags
 * @param int $mode
 * @param int $size
 * @return \Shmop|false
 */
function shmop_open(int $key, string $flags, int $mode, int $size)
{
    // 异常标记
    if(SharedMemoryMock::$enable_open_exception)
    {
        return false;
    }

    return \shmop_open($key, $flags, $mode, $size);
}

/**
 * mock shm_attach 方法
 *
 * @author fdipzone
 * @DateTime 2026-08-11 22:08:46
 *
 * @param int $key
 * @param int $size
 * @param int $permissions
 * @return \SysvSharedMemory|false
 */
function shm_attach(int $key, int $size = 10000, int $permissions = 0666)
{
    // 异常标记
    if(SharedMemoryMock::$enable_attach_exception)
    {
        return false;
    }

    return \shm_attach($key, $size, $permissions);
}