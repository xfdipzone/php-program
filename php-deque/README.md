# php-deque

php 双向队列类

## 介绍

php 实现的双向队列（double-ended queue）

基于数组存储，支持限定队列长度，入队受限，出队受限，及入队与出队必须同端几种设置

使用 `SyncMutex` 实现并发安全

[https://www.php.net/manual/zh/class.syncmutex.php](<https://www.php.net/manual/zh/class.syncmutex.php>)

---

## 扩展依赖

**SyncMutex** 需要安装 `sync` 扩展

检查是否已安装 `sync` 扩展

```shell
php -m | grep sync
```

安装 `sync` 扩展

```shell
pecl install sync
```

---

## 功能

支持以下队列类型

- 头部与尾部都能入队与出队，没有限制

- 限制头部只能入队不能出队，尾部可入队出队

- 限制头部只能出队不能入队，尾部可入队出队

- 限制尾部只能入队不能出队，头部可入队出队

- 限制尾部只能出队不能入队，头部可入队出队

- 头部尾部均可入队出队，限制元素只能在入队端出队

---

## 演示

```php
// 入队出队不限制
$de_queue = \DEQue\Queue::getInstance('double_queue', \DEQue\Type::UNRESTRICTED, 10);
$de_queue->pushFront(new \DEQue\Item('a'));
$de_queue->pushRear(new \DEQue\Item('b'));
$de_queue->pushFront(new \DEQue\Item('c'));
$de_queue->pushRear(new \DEQue\Item('d'));
$de_queue->pushFront(new \DEQue\Item('e'));

$resp = $de_queue->popFront();
assert($resp->item()->data()=='e');

$resp = $de_queue->popFront();
assert($resp->item()->data()=='c');

$resp = $de_queue->popFront();
assert($resp->item()->data()=='a');

$resp = $de_queue->popRear();
assert($resp->item()->data()=='d');

$resp = $de_queue->popRear();
assert($resp->item()->data()=='b');
```

---

## SyncMutex 多进程并发演示

多个子进程并发获取锁，只有一个子进程获取成功，其他子进程获取超时

```php
// 创建 SyncMutex 对象
$mutex = new \SyncMutex('my_mutex');

// 创建多个子进程
for($i=0; $i<5; $i++)
{
    $pid = pcntl_fork();

    if($pid==-1)
    {
        // 创建子进程失败
        exit('无法创建子进程');
    }
    elseif($pid)
    {
        // 父进程
        continue;
    }
    else
    {
        // 子进程，尝试 10ms 内获取锁
        if($mutex->lock(10))
        {
            printf("进程 %d 获取锁成功\n", getmypid());

            // 延迟 20 ms
            usleep(20000);

            // 解锁
            $mutex->unlock();
        }
        else
        {
            printf("进程 %d 获取锁超时\n", getmypid());
        }

        // 退出子进程
        exit();
    }
}

// 等待所有子进程运行结束
while(pcntl_waitpid(0, $status)!=-1);
```

更多功能演示可参考单元测试代码 [DEQue Unit Test](<../tests/DEQue>)
