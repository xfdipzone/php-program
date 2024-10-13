<?php declare(strict_types=1);
namespace Tests\SharedData;

/**
 * 测试 php-shared-data\SharedData\SharedMemoryUtils
 *
 * @author fdipzone
 */
final class SharedMemoryUtilsTest extends \Tests\SharedData\AbstractSharedMemoryTestCase
{
    /**
     * @covers \SharedData\SharedMemoryUtils::createIpcFile
     */
    public function testCreateIpcFile()
    {
        // 测试文件
        $ipc_file = '/tmp/sm-key-test.ipc';

        // IPC 文件不存在
        $created = \SharedData\SharedMemoryUtils::createIpcFile($ipc_file);
        $this->assertTrue($created);

        // IPC 文件已存在
        $created = \SharedData\SharedMemoryUtils::createIpcFile($ipc_file);
        $this->assertFalse($created);

        // 删除测试文件
        if(file_exists($ipc_file))
        {
            unlink($ipc_file);
        }
    }

    /**
     * @covers \SharedData\SharedMemoryUtils::removeIpcFile
     */
    public function testRemoveIpcFile()
    {
        // 测试文件
        $ipc_file = '/tmp/sm-key-test.ipc';

        // 预先创建 IPC 文件
        file_put_contents($ipc_file, '');

        // IPC 文件已存在
        $removed = \SharedData\SharedMemoryUtils::removeIpcFile($ipc_file);
        $this->assertTrue($removed);

        // IPC 文件不存在
        $removed = \SharedData\SharedMemoryUtils::removeIpcFile($ipc_file);
        $this->assertFalse($removed);
    }

    /**
     * @covers \SharedData\SharedMemoryUtils::semId
     */
    public function testSemId()
    {
        $shared_key = $this->generateSharedKey();
        $sem_ipc_file = '/tmp/'.$shared_key.'-sem.ipc';
        $project_id = 's';

        // 预先创建 IPC 文件
        file_put_contents($sem_ipc_file, '');

        $sem_id = \SharedData\SharedMemoryUtils::semId($sem_ipc_file, $project_id);
        $this->assertEquals('sysvsem', get_resource_type($sem_id));
    }

    /**
     * @covers \SharedData\SharedMemoryUtils::semId
     */
    public function testSemIdFalse()
    {
        $shared_key = $this->generateSharedKey();
        $sem_ipc_file = '/tmp/'.$shared_key.'-sem.ipc';
        $project_id = 's';

        $sem_id = \SharedData\SharedMemoryUtils::semId($sem_ipc_file, $project_id);
        $this->assertFalse($sem_id);
    }

    /**
     * @covers \SharedData\SharedMemoryUtils::shmKey
     */
    public function testShmKey()
    {
        $shared_key = $this->generateSharedKey();
        $shm_ipc_file = '/tmp/'.$shared_key.'.ipc';
        $project_id = 'm';

        // 预先创建 IPC 文件
        file_put_contents($shm_ipc_file, '');

        $shm_key = \SharedData\SharedMemoryUtils::shmKey($shm_ipc_file, $project_id);
        $this->assertTrue($shm_key>0);
    }
}