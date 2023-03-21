# php-hexfile

php 文件与16进制相互转换

## 介绍

本文介绍使用php实现文件内容与16进制相互转换，例如可以把文件转为16进制后保存到数据库中，也可以把16进制数据转为文件保存。

---

## 演示

```php
require 'HexFileConverter.php';

$file = 'doc.txt';

// 文件转16进制串
$hex_str = HexFileConverter::fileToHex($file);

// 16进制串转文件
$new_file = 'new_doc.txt';
HexFileConverter::hexToFile($hex_str, $new_file);
```
