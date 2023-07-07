# php-charset-convertor

php 字符编码转换类

## 介绍

php 字符编码转化类，实现数据转换为指定的编码

---

## 功能

支持ANSI、UTF-16、UTF-16 Big Endian、UTF-8、UTF-8+Bom编码的数据互相转换

---

## 演示

```php
require 'CharsetConvertor.php';

define('ROOT_PATH', dirname(__FILE__));

// source ansi
$str = file_get_contents(ROOT_PATH.'/test_data/ansi.txt');

// source utf8
$utf8_source_str = file_get_contents(ROOT_PATH.'/test_data/utf8.txt');

// convert UTF-8 to ANSI
$ansi_str = CharsetConvertor::convert($utf8_source_str, CharsetConvertor::UTF8, CharsetConvertor::ANSI);

// convert ANSI to UTF-8
$utf8_str = CharsetConvertor::convert($str, CharsetConvertor::ANSI, CharsetConvertor::UTF8);

// convert ANSI to UTF-8+Bom
$utf8bom_str = CharsetConvertor::convert($str, CharsetConvertor::ANSI, CharsetConvertor::UTF8BOM);

// convert ANSI to UTF-16
$utf16_str = CharsetConvertor::convert($str, CharsetConvertor::ANSI, CharsetConvertor::UTF16);

// convert ANSI to UTF-16 Big Endian
$utf16be_str = CharsetConvertor::convert($str, CharsetConvertor::ANSI, CharsetConvertor::UTF16BE);

// 将转换后的数据写入文件
file_put_contents('/tmp/convert_ansi.txt', $ansi_str);
file_put_contents('/tmp/convert_utf8.txt', $utf8_str);
file_put_contents('/tmp/convert_utf8-bom.txt', $utf8bom_str);
file_put_contents('/tmp/convert_utf16.txt', $utf16_str);
file_put_contents('/tmp/convert_utf16-be.txt', $utf16be_str);
```
