# php-file-downloader

PHP 文件断点续传下载类

## 介绍

php 实现的文件断点续传下载类

### HTTP断点续传原理

Http头 Range、Content-Range()

HTTP头中一般断点下载时才用到 `Range` 和 `Content-Range` 实体头

Range用户请求头中，指定第一个字节的位置和最后一个字节的位置，如（Range：200-300）

Content-Range用于响应头

请求下载整个文件：

```txt
GET /demo.zip HTTP/1.1
Connection: close
Host: 127.0.0.1
Range: bytes=0-801 //一般请求下载整个文件是bytes=0- 或不用这个头
```

一般正常回应：

```txt
HTTP/1.1 200 OK
Content-Length: 801
Content-Type: application/octet-stream
Content-Range: bytes 0-800/801 //801:文件总大小
```

---

## 功能

- 设置每次读取下载文件的字节数，默认512kb

- 设置是否开启断点续传，默认开启

---

## 演示

```php
require 'FileDownloader.php';

$file = dirname(__FILE__).'/demo.zip';
$downloader = new FileDownloader(256, true); // true: 开启断点续传 false: 关闭断点续传
$downloader->download($file, 'new_demo.zip');
```

---

## 断点续传测试方法

使用 linux 的 **wget** 命令测试下载，分别设置开启与关闭断点续传测试

测试时，可在 `FileDownloader` 文件 `line 108` 中，开启 `sleep` 语句来减慢下载速度测试

```shell
# 开启下载，下载部分后使用 ctrl+c 中止
wget -O new_demo.zip http://localhost/test/demo.php

# 加入 -c 参数，继续执行，可以看到会从上次下载的地方继续下载（断点续传）
wget -c -O new_demo.zip http://localhost/test/demo.php
```

执行效果

```txt
已发出 HTTP 请求，正在等待回应... 200 OK
长度： 10445120 (10.0M) [application/octet-stream]
正在保存至: "new_demo.zip"

20% [=========>                                         ] 2,097,720    516K/s  估时 16s
^C


已发出 HTTP 请求，正在等待回应... 206 Partial Content
长度： 10445121 (10.0M)，7822971 (7.5M) 字节剩余 [application/octet-stream]
正在保存至: "new_demo.zip"

100%[++++++++++========================================>] 10,445,121   543K/s   花时 14s

2023-09-08 11:53:45 (543 KB/s) - 已保存 "new_demo.zip" [10445121/10445121])
```
