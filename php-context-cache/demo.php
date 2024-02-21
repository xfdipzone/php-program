<?php
require 'autoload.php';

// 获取上下文缓存组件实例
$context_cache = \ContextCache\Cache::GetInstance();

// 设置缓存 return: true
var_dump($context_cache->Put('name', 'fdipzone'));

// 读取缓存 return: fdipzone
var_dump($context_cache->Get('name'));

// 移除缓存 return: true
var_dump($context_cache->Remove('name'));

// 读取不存在的缓存 return: null
var_dump($context_cache->Get('name'));

// 移除不存在的缓存 return: false
var_dump($context_cache->Remove('name'));

// 清空所有缓存
$context_cache->Put('name', 'fdipzone');
var_dump($context_cache->Get('name'));

$context_cache->Clear();

// 清空所有缓存后再读取
var_dump($context_cache->Get('name'));