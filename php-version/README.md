# php-version

php 版本比对类

## 介绍

php 版本比对类，实现版本号与数字相互转换，比对版本号大小

版本号转为版本数字，可以提升版本号比对效率，节省版本号存储空间

---

## 功能

- 版本号转为版本数字（例: 1.0.0 -> 10000）

- 版本数字转为版本号（例: 10000 -> 1.0.0）

- 检查版本号格式

- 比对版本号大小

---

## 演示

```php
require 'Version.php';

// 版本转数字
$version = '2.7.1';
$version_number = Version::versionToInteger($version);
echo $version_number.PHP_EOL; // 20701

// 数字转版本
$version_number = 20701;
$version = Version::integerToVersion($version_number);
echo $version.PHP_EOL; // 2.7.1

// 检查版本
$version = '1.1.1';
var_dump(Version::validate($version)); // true

$version = '1.1.a';
var_dump(Version::validate($version)); // false

// 比较两个版本
$version1 = '1.0.0';
$version2 = '1.0.0';
echo Version::compare($version1, $version2).PHP_EOL; // 0

$version1 = '1.0.1';
$version2 = '1.0.0';
echo Version::compare($version1, $version2).PHP_EOL; // 1

$version1 = '0.99.99';
$version2 = '1.0.0';
echo Version::compare($version1, $version2).PHP_EOL; // -1
```
