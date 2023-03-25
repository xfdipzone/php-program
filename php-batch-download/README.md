# php-batch-download

php 利用curl实现多进程下载文件

## php 利用curl实现多进程下载文件

批量下载文件一般使用循环的方式，逐一执行下载。但在带宽与服务器性能允许的情况下，使用多进程进行下载可以大大提高下载的效率。

---

## 原理

使用 `curl` 的批处理方法，开启多进程，实现批量下载文件。

---

## 主要方法

**curl_multi_init**
返回一个新cURL批处理句柄

**curl_multi_add_handle**
向curl批处理会话中添加单独的curl句柄

**curl_multi_exec**
运行当前 cURL 句柄的子连接

**curl_multi_getcontent**
如果设置了CURLOPT_RETURNTRANSFER，则返回获取的输出的文本流

**curl_multi_remove_handle**
移除curl批处理句柄资源中的某个句柄资源

**curl_multi_close**
关闭一组cURL句柄

---

## 演示

```php
require 'BatchDownLoad.php';

$base_path = dirname(__FILE__).'/photo';

if(!is_dir($base_path)){
    mkdir($base_path, 0777, true);
}

$download_config = array(
    array('http://www.example.com/p1.jpg', $base_path.'/p1.jpg'),
    array('http://www.example.com/p2.jpg', $base_path.'/p2.jpg'),
    array('http://www.example.com/p3.jpg', $base_path.'/p3.jpg'),
    array('http://www.example.com/p4.jpg', $base_path.'/p4.jpg'),
    array('http://www.example.com/p5.jpg', $base_path.'/p5.jpg'),
);

$obj = new BatchDownLoad($download_config, 2, 10);
$handle_num = $obj->download();

echo 'download num:'.$handle_num.PHP_EOL;
```

执行后日志输出

```txt
[2017-07-16 18:04:21] url:http://www.example.com/p1.jpg file:/home/fdipzone/photo/p1.jpg status:1
[2017-07-16 18:04:21] url:http://www.example.com/p2.jpg file:/home/fdipzone/photo/p2.jpg status:1
[2017-07-16 18:04:21] url:http://www.example.com/p3.jpg file:/home/fdipzone/photo/p3.jpg status:1
[2017-07-16 18:04:21] url:http://www.example.com/p4.jpg file:/home/fdipzone/photo/p4.jpg status:1
[2017-07-16 18:04:21] url:http://www.example.com/p5.jpg file:/home/fdipzone/photo/p5.jpg status:1
```
