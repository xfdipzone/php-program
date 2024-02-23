# php-context-cache

php上下文缓存类

## 介绍

php实现的上下文缓存类，用于在一个请求中设置与获取暂存数据，减少多次重复计算与调用第三方

暂时只实现了基于本地 HashMap 存储，不支持跨服务设置与获取数据

---

## 功能

在一个请求的生命周期中，设置与获取暂存的数据

- 设置缓存数据

- 获取缓存数据

- 移除缓存数据

- 清空所有缓存数据

---

## 演示

```php
require 'autoload.php';

// 获取上下文缓存组件实例
$context_cache = \ContextCache\Cache::getInstance();

// 设置缓存 return: true
var_dump($context_cache->put('name', 'fdipzone'));

// 读取缓存 return: fdipzone
var_dump($context_cache->get('name'));

// 移除缓存 return: true
var_dump($context_cache->remove('name'));

// 读取不存在的缓存 return: null
var_dump($context_cache->get('name'));

// 移除不存在的缓存 return: false
var_dump($context_cache->remove('name'));

// 清空所有缓存
$context_cache->put('name', 'fdipzone');
var_dump($context_cache->get('name'));

$context_cache->clear();

// 清空所有缓存后再读取
var_dump($context_cache->get('name'));
```
