<?php declare(strict_types=1);
namespace Tests\SharedData;

/**
 * 测试 php-shared-data\SharedData\KVSharedMemory
 *
 * @author fdipzone
 */
final class KVSharedMemoryTest extends \Tests\SharedData\AbstractSharedMemoryTestCase
{
    /**
     * @covers \SharedData\KVSharedMemory::__construct
     */
    public function testConstruct()
    {
        $shared_key = $this->generateSharedKey();
        $shared_size = 128;
        $kv_shared_memory = new \SharedData\KVSharedMemory($shared_key, $shared_size);
        $this->assertEquals('SharedData\KVSharedMemory', get_class($kv_shared_memory));
    }

    /**
     * @covers \SharedData\KVSharedMemory::__construct
     */
    public function testConstructSharedKeyException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('kv shared memory: shared key is empty');

        $shared_key = '';
        $shared_size = 128;
        new \SharedData\KVSharedMemory($shared_key, $shared_size);
    }

    /**
     * @covers \SharedData\KVSharedMemory::__construct
     */
    public function testConstructSharedSizeException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('kv shared memory: shared size must be greater than 0');

        $shared_key = $this->generateSharedKey();
        $shared_size = 0;
        new \SharedData\KVSharedMemory($shared_key, $shared_size);
    }

    /**
     * @covers \SharedData\KVSharedMemory::__construct
     */
    public function testConstructCreateShmIpcFileException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('kv shared memory: shm ipc file already exists or create fail');

        $shared_key = $this->generateSharedKey();
        $shared_size = 128;

        // 预先创建共享内存 IPC 文件
        file_put_contents('/tmp/'.$shared_key.'-kv.ipc', '');

        new \SharedData\KVSharedMemory($shared_key, $shared_size);
    }

    /**
     * @covers \SharedData\KVSharedMemory::__construct
     */
    public function testConstructCreateSemIpcFileException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('kv shared memory: sem ipc file already exists or create fail');

        $shared_key = $this->generateSharedKey();
        $shared_size = 128;

        // 预先创建信号量 IPC 文件
        file_put_contents('/tmp/'.$shared_key.'-kv-sem.ipc', '');

        new \SharedData\KVSharedMemory($shared_key, $shared_size);
    }

    /**
     * @covers \SharedData\KVSharedMemory::store
     */
    public function testStore()
    {
        $shared_key = $this->generateSharedKey();
        $shared_size = 128;
        $kv_shared_memory = new \SharedData\KVSharedMemory($shared_key, $shared_size);

        // 写入数据
        $key = 'test';
        $data = 'kv shared memory content';
        $ret = $kv_shared_memory->store($key, $data);
        $this->assertTrue($ret);

        // 关闭共享内存
        $closed = $kv_shared_memory->close();
        $this->assertTrue($closed);
    }

    /**
     * @covers \SharedData\KVSharedMemory::store
     */
    public function testStoreKeyEmptyException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('kv shared memory: store key is empty');

        $shared_key = $this->generateSharedKey();
        $shared_size = 128;
        $kv_shared_memory = new \SharedData\KVSharedMemory($shared_key, $shared_size);

        $key = '';
        $data = 'kv shared memory content';
        $kv_shared_memory->store($key, $data);
    }

    /**
     * @covers \SharedData\KVSharedMemory::store
     */
    public function testStoreDataEmptyException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('kv shared memory: store data is empty');

        $shared_key = $this->generateSharedKey();
        $shared_size = 128;
        $kv_shared_memory = new \SharedData\KVSharedMemory($shared_key, $shared_size);

        $key = 'test';
        $data = [];
        $kv_shared_memory->store($key, $data);
    }

    /**
     * @covers \SharedData\KVSharedMemory::store
     */
    public function testStoreException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('kv shared memory: shm_id create fail');

        $shared_key = $this->generateSharedKey();
        $shared_size = 1024 * 1024 * 128; // 128M 设置超大的共享内存块
        $kv_shared_memory = new \SharedData\KVSharedMemory($shared_key, $shared_size);

        // 写入数据
        $key = 'test';
        $data = 'kv shared memory content';
        $kv_shared_memory->store($key, $data);
    }

    /**
     * @covers \SharedData\KVSharedMemory::store
     */
    public function testStoreSemIdException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('kv shared memory: semaphore acquire fail');

        $shared_key = $this->generateSharedKey();
        $shared_size = 128;
        $kv_shared_memory = new \SharedData\KVSharedMemory($shared_key, $shared_size);

        // 写入数据
        $key = 'test';
        $data = 'kv shared memory content';
        $ret = $kv_shared_memory->store($key, $data);
        $this->assertTrue($ret);

        // 关闭共享内存
        $closed = $kv_shared_memory->close();
        $this->assertTrue($closed);

        // 关闭之后再执行写入
        $kv_shared_memory->store($key, $data);
    }

    /**
     * @covers \SharedData\KVSharedMemory::store
     */
    public function testStoreShmKeyException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('kv shared memory: shm_key invalid');

        $shared_key = $this->generateSharedKey();
        $shared_size = 128;
        $kv_shared_memory = new \SharedData\KVSharedMemory($shared_key, $shared_size);

        // 写入数据
        $key = 'test';
        $data = 'kv shared memory content';
        $ret = $kv_shared_memory->store($key, $data);
        $this->assertTrue($ret);

        // 关闭共享内存
        $closed = $kv_shared_memory->close();
        $this->assertTrue($closed);

        // 重新创建信号量 IPC 文件，使信号量锁获取成功，方便测试后续流程的异常
        file_put_contents('/tmp/'.$shared_key.'-kv-sem.ipc', '');

        // 关闭之后再执行写入
        $kv_shared_memory->store($key, $data);
    }

    /**
     * @covers \SharedData\KVSharedMemory::load
     */
    public function testLoad()
    {
        $shared_key = $this->generateSharedKey();
        $shared_size = 128;
        $kv_shared_memory = new \SharedData\KVSharedMemory($shared_key, $shared_size);

        // 写入数据
        $key = 'test';
        $data = 'kv shared memory content';
        $kv_shared_memory->store($key, $data);

        // 读取数据
        $load_data = $kv_shared_memory->load($key);
        $this->assertEquals($data, $load_data);

        // 写入数组数据
        $data = array(
            'name' => 'fdipzone'
        );
        $kv_shared_memory->store($key, $data);

        // 读取数组数据
        $load_data = $kv_shared_memory->load($key);
        $this->assertEquals('fdipzone', $load_data['name']);

        // 关闭共享内存
        $closed = $kv_shared_memory->close();
        $this->assertTrue($closed);
    }

    /**
     * @covers \SharedData\KVSharedMemory::load
     */
    public function testLoadKeyEmptyException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('kv shared memory: load key is empty');

        $shared_key = $this->generateSharedKey();
        $shared_size = 128;
        $kv_shared_memory = new \SharedData\KVSharedMemory($shared_key, $shared_size);

        // 读取数据
        $key = '';
        $kv_shared_memory->load($key);
    }

    /**
     * @covers \SharedData\KVSharedMemory::load
     */
    public function testLoadSemIdException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('kv shared memory: semaphore acquire fail');

        $shared_key = $this->generateSharedKey();
        $shared_size = 128;
        $kv_shared_memory = new \SharedData\KVSharedMemory($shared_key, $shared_size);

        // 写入数据
        $key = 'test';
        $data = 'kv shared memory content';
        $kv_shared_memory->store($key, $data);

        // 关闭共享内存
        $closed = $kv_shared_memory->close();
        $this->assertTrue($closed);

        // 关闭之后再执行读取
        $kv_shared_memory->load($key);
    }

    /**
     * @covers \SharedData\KVSharedMemory::load
     */
    public function testLoadException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('kv shared memory: shm_id get fail');

        $shared_key = $this->generateSharedKey();
        $shared_size = 128;
        $kv_shared_memory = new \SharedData\KVSharedMemory($shared_key, $shared_size);

        // 写入数据
        $key = 'test';
        $data = 'kv shared memory content';
        $kv_shared_memory->store($key, $data);

        // 关闭共享内存
        $closed = $kv_shared_memory->close();
        $this->assertTrue($closed);

        // 重新创建信号量 IPC 文件，使信号量锁获取成功，方便测试后续流程的异常
        file_put_contents('/tmp/'.$shared_key.'-kv-sem.ipc', '');

        // 关闭之后再执行读取
        $kv_shared_memory->load($key);
    }

    /**
     * @covers \SharedData\KVSharedMemory::remove
     */
    public function testClear()
    {
        $shared_key = $this->generateSharedKey();
        $shared_size = 128;
        $kv_shared_memory = new \SharedData\KVSharedMemory($shared_key, $shared_size);

        // 写入数据
        $key = 'test';
        $data = 'kv shared memory content';
        $kv_shared_memory->store($key, $data);

        // 清空
        $ret = $kv_shared_memory->remove($key);
        $this->assertTrue($ret);

        // 读取数据
        $load_data = $kv_shared_memory->load($key);
        $this->assertEquals(null, $load_data);

        // 关闭共享内存
        $closed = $kv_shared_memory->close();
        $this->assertTrue($closed);
    }

    /**
     * @covers \SharedData\KVSharedMemory::remove
     */
    public function testRemoveKeyEmptyException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('kv shared memory: remove key is empty');

        $shared_key = $this->generateSharedKey();
        $shared_size = 128;
        $kv_shared_memory = new \SharedData\KVSharedMemory($shared_key, $shared_size);

        // 移除数据
        $key = '';
        $kv_shared_memory->remove($key);
    }

    /**
     * @covers \SharedData\KVSharedMemory::remove
     */
    public function testRemoveSemIdException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('kv shared memory: semaphore acquire fail');

        $shared_key = $this->generateSharedKey();
        $shared_size = 128;
        $kv_shared_memory = new \SharedData\KVSharedMemory($shared_key, $shared_size);

        // 写入数据
        $key = 'test';
        $data = 'kv shared memory content';
        $kv_shared_memory->store($key, $data);

        // 关闭共享内存
        $closed = $kv_shared_memory->close();
        $this->assertTrue($closed);

        // 关闭之后再执行清空
        $kv_shared_memory->remove($key);
    }

    /**
     * @covers \SharedData\KVSharedMemory::remove
     */
    public function testRemoveException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('kv shared memory: shm_id get fail');

        $shared_key = $this->generateSharedKey();
        $shared_size = 128;
        $kv_shared_memory = new \SharedData\KVSharedMemory($shared_key, $shared_size);

        // 写入数据
        $key = 'test';
        $data = 'kv shared memory content';
        $kv_shared_memory->store($key, $data);

        // 关闭共享内存
        $closed = $kv_shared_memory->close();
        $this->assertTrue($closed);

        // 重新创建信号量 IPC 文件，使信号量锁获取成功，方便测试后续流程的异常
        file_put_contents('/tmp/'.$shared_key.'-kv-sem.ipc', '');

        // 关闭之后再执行清空
        $kv_shared_memory->remove($key);
    }

    /**
     * @covers \SharedData\KVSharedMemory::close
     */
    public function testClose()
    {
        $shared_key = $this->generateSharedKey();
        $shared_size = 128;
        $kv_shared_memory = new \SharedData\KVSharedMemory($shared_key, $shared_size);

        // 写入数据
        $key = 'test';
        $data = 'kv shared memory content';
        $kv_shared_memory->store($key, $data);

        // 关闭共享内存
        $closed = $kv_shared_memory->close();
        $this->assertTrue($closed);
    }

    /**
     * @covers \SharedData\KVSharedMemory::close
     */
    public function testCloseSemIdException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('kv shared memory: semaphore acquire fail');

        $shared_key = $this->generateSharedKey();
        $shared_size = 128;
        $kv_shared_memory = new \SharedData\KVSharedMemory($shared_key, $shared_size);

        // 写入数据
        $key = 'test';
        $data = 'kv shared memory content';
        $kv_shared_memory->store($key, $data);

        // 关闭共享内存
        $closed = $kv_shared_memory->close();
        $this->assertTrue($closed);

        // 关闭之后再执行关闭
        $kv_shared_memory->close();
    }

    /**
     * @covers \SharedData\KVSharedMemory::close
     */
    public function testCloseException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('kv shared memory: shm_id get fail');

        $shared_key = $this->generateSharedKey();
        $shared_size = 128;
        $kv_shared_memory = new \SharedData\KVSharedMemory($shared_key, $shared_size);

        // 写入数据
        $key = 'test';
        $data = 'kv shared memory content';
        $kv_shared_memory->store($key, $data);

        // 关闭共享内存
        $closed = $kv_shared_memory->close();
        $this->assertTrue($closed);

        // 重新创建信号量 IPC 文件，使信号量锁获取成功，方便测试后续流程的异常
        file_put_contents('/tmp/'.$shared_key.'-kv-sem.ipc', '');

        // 关闭之后再执行关闭
        $kv_shared_memory->close();
    }

    /**
     * @covers \SharedData\KVSharedMemory::keyConvert
     */
    public function testKeyConvert()
    {
        $shared_key = $this->generateSharedKey();
        $shared_size = 128;
        $kv_shared_memory = new \SharedData\KVSharedMemory($shared_key, $shared_size);

        $key = 'test';
        $expect_key = hexdec(hash('crc32b', $key));
        $int_key = \Tests\Utils\PHPUnitExtension::callMethod($kv_shared_memory, 'keyConvert', [$key]);
        $this->assertEquals($expect_key, $int_key);
    }
}