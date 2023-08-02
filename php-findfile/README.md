# php-findfile

PHP 遍历文件夹处理类

## 介绍

php 实现的文件夹遍历类，可以设置遍历的文件夹深度，并对遍历出的文件执行自定义处理。

---

## 功能

**AbstractFindFile** 抽象类，用于遍历文件夹文件

**UnsetUtf8Bom** 继承 `AbstractFindFile` 的子类，用于实现将遍历的文件执行去除 `utf8+Bom` 头处理

---

## 演示

```php
require 'AbstractFindFile.php';
require 'UnsetUtf8Bom.php';
require 'TestUtil.php';

define('ROOT_PATH', dirname(__FILE__));

// 测试源数据目录
$source = ROOT_PATH.'/test_data';

// 测试目录
$test_folder = ROOT_PATH.'/test_data/result';

// 将测试源文件复制到测试目录
InitTestData($source, $test_folder);

// 定义要处理的文件类型
$file_type = array('txt', 'css', 'js');

$oUnsetUtf8Bom = new UnsetUtf8Bom($file_type);

// 不设置搜索深度，遍历所有子文件夹，因此会处理sub_folder内文件
$oUnsetUtf8Bom->find($test_folder);

// 设置搜索深度为1，只遍历当前层文件夹，因此不会处理sub_folder内文件
//$oUnsetUtf8Bom->find($test_folder, 1);

$response = $oUnsetUtf8Bom->response();

print_r($oUnsetUtf8Bom->response());
```
