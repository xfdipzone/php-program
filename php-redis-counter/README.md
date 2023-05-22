# php-redis-counter

php 基于redis计数器类

## 介绍

使用php开发基于redis实现自增计数类，对并发调用时自增计数的唯一性也做了检查验证，保证并发执行时自增计数唯一。提供完整代码及演示实例，方便大家学习使用。

---

## 功能

php基于Redis实现自增计数，主要使用redis的incr方法，并发执行时保证计数自增唯一。

1.自增计数。

2.返回当前计数。

3.重置计数。

---

## 演示

```php
require 'RedisCounter.php';

// redis连接设定
$config = array(
    'host' => 'redis',
    'port' => 6379,
    'index' => 0,
    'auth' => '',
    'timeout' => 1,
    'reserved' => NULL,
    'retry_interval' => 100,
);

// 创建RedisCounter对象
$oRedisCounter = new RedisCounter($config);

// 定义保存计数的健值
$key = 'my-counter';

// 执行自增计数，获取当前计数，重置计数
echo $oRedisCounter->get($key).PHP_EOL; // 0
echo $oRedisCounter->incr($key).PHP_EOL; // 1
echo $oRedisCounter->incr($key, 10).PHP_EOL; // 11
echo $oRedisCounter->reset($key).PHP_EOL; // 1
echo $oRedisCounter->get($key).PHP_EOL; // 0
```

输出

```txt
0
1
11
1
0
```

---

## 测试并发

关于测试并发可以参考博客 [http://blog.csdn.net/fdipzone/article/details/78376411#t1](http://blog.csdn.net/fdipzone/article/details/78376411#t1)
