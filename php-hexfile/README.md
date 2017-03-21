# php-hexfile
php 文件与16进制相互转换<br><br>

本文介绍使用php实现文件内容与16进制相互转换，例如可以把文件转为16进制后保存到数据库中，也可以把16进制数据转为文件保存。<br><br>

## 演示
```php
$file = 'test.doc';

// 文件转16进制
$hexstr = fileToHex($file);
echo '文件转16进制<br>';
echo $hexstr.'<br><br>';

// 16进制转文件
$newfile = 'new.doc';
hexToFile($hexstr, $newfile);

echo '16进制转文件<br>';
var_dump(file_exists($newfile));
```

输出：

```txt
文件转16进制
efbbbf3130e4b8aae4bfafe58da7e69291e28094e280943235e4b8aae4bbb0e58da7e8b5b7...

16进制转文件
boolean true
```
