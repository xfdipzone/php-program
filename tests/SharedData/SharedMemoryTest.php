<?php declare(strict_types=1);
namespace Tests\SharedData;

/**
 * 测试 php-shared-data\SharedData\SharedMemory
 *
 * @author fdipzone
 */
final class SharedMemoryTest extends \Tests\SharedData\AbstractSharedMemoryTestCase
{
    /**
     * @covers \SharedData\SharedMemory::__construct
     */
    public function testConstruct()
    {
        $shared_key = $this->generateSharedKey();
        $shared_size = 128;
        $shared_memory = new \SharedData\SharedMemory($shared_key, $shared_size);
        $this->assertEquals('SharedData\SharedMemory', get_class($shared_memory));
    }

    /**
     * @covers \SharedData\SharedMemory::__construct
     */
    public function testConstructSharedKeyException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('shared memory: shared key is empty');

        $shared_key = '';
        $shared_size = 128;
        new \SharedData\SharedMemory($shared_key, $shared_size);
    }

    /**
     * @covers \SharedData\SharedMemory::__construct
     */
    public function testConstructSharedSizeException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('shared memory: shared size must be greater than 0');

        $shared_key = $this->generateSharedKey();
        $shared_size = 0;
        new \SharedData\SharedMemory($shared_key, $shared_size);
    }

    /**
     * @covers \SharedData\SharedMemory::__construct
     */
    public function testConstructCreateShmIpcFileException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('shared memory: shm ipc file already exists or create fail');

        $shared_key = $this->generateSharedKey();
        $shared_size = 128;

        // 预先创建共享内存 IPC 文件
        file_put_contents('/tmp/'.$shared_key.'.ipc', '');

        new \SharedData\SharedMemory($shared_key, $shared_size);
    }

    /**
     * @covers \SharedData\SharedMemory::__construct
     */
    public function testConstructCreateSemIpcFileException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('shared memory: sem ipc file already exists or create fail');

        $shared_key = $this->generateSharedKey();
        $shared_size = 128;

        // 预先创建信号量 IPC 文件
        file_put_contents('/tmp/'.$shared_key.'-sem.ipc', '');

        new \SharedData\SharedMemory($shared_key, $shared_size);
    }

    /**
     * @covers \SharedData\SharedMemory::store
     */
    public function testStore()
    {
        $shared_key = $this->generateSharedKey();
        $shared_size = 128;
        $shared_memory = new \SharedData\SharedMemory($shared_key, $shared_size);

        // 写入数据
        $data = 'shared memory content';
        $ret = $shared_memory->store($data);
        $this->assertTrue($ret);

        // 关闭共享内存
        $closed = $shared_memory->close();
        $this->assertTrue($closed);
    }

    /**
     * @covers \SharedData\SharedMemory::store
     */
    public function testStoreDataEmptyException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('shared memory: store data is empty');

        $shared_key = $this->generateSharedKey();
        $shared_size = 128;
        $shared_memory = new \SharedData\SharedMemory($shared_key, $shared_size);

        $data = '';
        $shared_memory->store($data);
    }

    /**
     * @covers \SharedData\SharedMemory::store
     */
    public function testStoreDataLengthException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('shared memory: store data length more than shared memory size');

        $shared_key = $this->generateSharedKey();
        $shared_size = 3;
        $shared_memory = new \SharedData\SharedMemory($shared_key, $shared_size);

        $data = 'abcd';
        $shared_memory->store($data);
    }

    /**
     * @covers \SharedData\SharedMemory::store
     */
    public function testStoreException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('shared memory: shm_id create fail');

        $shared_key = $this->generateSharedKey();
        $shared_size = 1024 * 1024 * 128; // 128M 设置超大的共享内存块
        $shared_memory = new \SharedData\SharedMemory($shared_key, $shared_size);

        // 写入数据
        $data = 'shared memory content';
        $shared_memory->store($data);
    }

    /**
     * @covers \SharedData\SharedMemory::store
     */
    public function testStoreSemIdException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('shared memory: semaphore acquire fail');

        $shared_key = $this->generateSharedKey();
        $shared_size = 128;
        $shared_memory = new \SharedData\SharedMemory($shared_key, $shared_size);

        // 写入数据
        $data = 'shared memory content';
        $ret = $shared_memory->store($data);
        $this->assertTrue($ret);

        // 关闭共享内存
        $closed = $shared_memory->close();
        $this->assertTrue($closed);

        // 关闭之后再执行写入
        $shared_memory->store($data);
    }

    /**
     * @covers \SharedData\SharedMemory::store
     */
    public function testStoreShmKeyException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('shared memory: shm_key invalid');

        $shared_key = $this->generateSharedKey();
        $shared_size = 128;
        $shared_memory = new \SharedData\SharedMemory($shared_key, $shared_size);

        // 写入数据
        $data = 'shared memory content';
        $ret = $shared_memory->store($data);
        $this->assertTrue($ret);

        // 关闭共享内存
        $closed = $shared_memory->close();
        $this->assertTrue($closed);

        // 重新创建信号量 IPC 文件，使信号量锁获取成功，方便测试后续流程的异常
        file_put_contents('/tmp/'.$shared_key.'-sem.ipc', '');

        // 关闭之后再执行写入
        $shared_memory->store($data);
    }

    /**
     * @covers \SharedData\SharedMemory::load
     */
    public function testLoad()
    {
        $shared_key = $this->generateSharedKey();
        $shared_size = 128;
        $shared_memory = new \SharedData\SharedMemory($shared_key, $shared_size);

        // 写入数据
        $data = 'shared memory content';
        $shared_memory->store($data);

        // 读取数据
        $load_data = $shared_memory->load();
        $this->assertEquals($data, $load_data);

        // 关闭共享内存
        $closed = $shared_memory->close();
        $this->assertTrue($closed);
    }

    /**
     * @covers \SharedData\SharedMemory::load
     */
    public function testLoadSemIdException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('shared memory: semaphore acquire fail');

        $shared_key = $this->generateSharedKey();
        $shared_size = 128;
        $shared_memory = new \SharedData\SharedMemory($shared_key, $shared_size);

        // 写入数据
        $data = 'shared memory content';
        $shared_memory->store($data);

        // 关闭共享内存
        $closed = $shared_memory->close();
        $this->assertTrue($closed);

        // 关闭之后再执行读取
        $shared_memory->load();
    }

    /**
     * @covers \SharedData\SharedMemory::load
     */
    public function testLoadException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('shared memory: shm_id get fail');

        $shared_key = $this->generateSharedKey();
        $shared_size = 128;
        $shared_memory = new \SharedData\SharedMemory($shared_key, $shared_size);

        // 写入数据
        $data = 'shared memory content';
        $shared_memory->store($data);

        // 关闭共享内存
        $closed = $shared_memory->close();
        $this->assertTrue($closed);

        // 重新创建信号量 IPC 文件，使信号量锁获取成功，方便测试后续流程的异常
        file_put_contents('/tmp/'.$shared_key.'-sem.ipc', '');

        // 关闭之后再执行读取
        $shared_memory->load();
    }

    /**
     * @covers \SharedData\SharedMemory::clear
     */
    public function testClear()
    {
        $shared_key = $this->generateSharedKey();
        $shared_size = 128;
        $shared_memory = new \SharedData\SharedMemory($shared_key, $shared_size);

        // 写入数据
        $data = 'shared memory content';
        $shared_memory->store($data);

        // 清空
        $ret = $shared_memory->clear();
        $this->assertTrue($ret);

        // 读取数据
        $load_data = $shared_memory->load();
        $this->assertEquals('', $load_data);

        // 关闭共享内存
        $closed = $shared_memory->close();
        $this->assertTrue($closed);
    }

    /**
     * @covers \SharedData\SharedMemory::clear
     */
    public function testClearSemIdException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('shared memory: semaphore acquire fail');

        $shared_key = $this->generateSharedKey();
        $shared_size = 128;
        $shared_memory = new \SharedData\SharedMemory($shared_key, $shared_size);

        // 写入数据
        $data = 'shared memory content';
        $shared_memory->store($data);

        // 关闭共享内存
        $closed = $shared_memory->close();
        $this->assertTrue($closed);

        // 关闭之后再执行清空
        $shared_memory->clear();
    }

    /**
     * @covers \SharedData\SharedMemory::clear
     */
    public function testClearException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('shared memory: shm_id get fail');

        $shared_key = $this->generateSharedKey();
        $shared_size = 128;
        $shared_memory = new \SharedData\SharedMemory($shared_key, $shared_size);

        // 写入数据
        $data = 'shared memory content';
        $shared_memory->store($data);

        // 关闭共享内存
        $closed = $shared_memory->close();
        $this->assertTrue($closed);

        // 重新创建信号量 IPC 文件，使信号量锁获取成功，方便测试后续流程的异常
        file_put_contents('/tmp/'.$shared_key.'-sem.ipc', '');

        // 关闭之后再执行清空
        $shared_memory->clear();
    }

    /**
     * @covers \SharedData\SharedMemory::close
     */
    public function testClose()
    {
        $shared_key = $this->generateSharedKey();
        $shared_size = 128;
        $shared_memory = new \SharedData\SharedMemory($shared_key, $shared_size);

        // 写入数据
        $data = 'shared memory content';
        $shared_memory->store($data);

        // 关闭共享内存
        $closed = $shared_memory->close();
        $this->assertTrue($closed);
    }

    /**
     * @covers \SharedData\SharedMemory::close
     */
    public function testCloseSemIdException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('shared memory: semaphore acquire fail');

        $shared_key = $this->generateSharedKey();
        $shared_size = 128;
        $shared_memory = new \SharedData\SharedMemory($shared_key, $shared_size);

        // 写入数据
        $data = 'shared memory content';
        $shared_memory->store($data);

        // 关闭共享内存
        $closed = $shared_memory->close();
        $this->assertTrue($closed);

        // 关闭之后再执行关闭
        $shared_memory->close();
    }

    /**
     * @covers \SharedData\SharedMemory::close
     */
    public function testCloseException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('shared memory: shm_id get fail');

        $shared_key = $this->generateSharedKey();
        $shared_size = 128;
        $shared_memory = new \SharedData\SharedMemory($shared_key, $shared_size);

        // 写入数据
        $data = 'shared memory content';
        $shared_memory->store($data);

        // 关闭共享内存
        $closed = $shared_memory->close();
        $this->assertTrue($closed);

        // 重新创建信号量 IPC 文件，使信号量锁获取成功，方便测试后续流程的异常
        file_put_contents('/tmp/'.$shared_key.'-sem.ipc', '');

        // 关闭之后再执行关闭
        $shared_memory->close();
    }

    /**
     * @covers \SharedData\SharedMemory::closeShmId
     */
    public function testCloseShmId()
    {
        $shared_key = $this->generateSharedKey();
        $shared_size = 128;
        $shared_memory = new \SharedData\SharedMemory($shared_key, $shared_size);

        // 测试文件
        $ipc_file = '/tmp/sm-key-test.ipc';

        // 预先创建 IPC 文件
        file_put_contents($ipc_file, '');

        $shm_key = ftok($ipc_file, 'm');
        $shm_id = shmop_open($shm_key, 'c', 0644, 10);
        $this->assertEquals('shmop', get_resource_type($shm_id));

        $written = shmop_write($shm_id, 'abc', 0);
        $this->assertSame(3, $written);

        $deleted = shmop_delete($shm_id);
        $this->assertTrue($deleted);
        $this->assertEquals('shmop', get_resource_type($shm_id));

        // 关闭
        \Tests\Utils\PHPUnitExtension::callMethod($shared_memory, 'closeShmId', [$shm_id]);
        $this->assertEquals('Unknown', get_resource_type($shm_id));

        // 删除测试文件
        if(file_exists($ipc_file))
        {
            unlink($ipc_file);
        }
    }
}