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
