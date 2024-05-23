# php-restore-print

php 将 print_r() 处理后的数据还原为原始数组的方法

## 介绍

php **print_r()** 方法可以把变量打印显示，使变量易于理解

如果变量是 `string`, `integer` 或 `float`，将打印变量值本身

如果变量是 `array`，将会按照一定格式显示键和元素

object 与数组类似，print_r() 用于打印数组较多

php 原生没有方法可以把 print_r() 方法打印后的数据还原为原始数组

---

## 功能

实现将 php print_r() 方法处理后的数据还原为原始数组

---

## 演示

```php
<?php
require 'RestorePrint.php';

$print_r_data = <<<TXT
Array
(
    [name] => fdipzone
    [gender] => male
    [age] => 18
    [profession] => programmer
    [detail] => Array
        (
            [grade] => 1
            [create_time] => 2024-05-23
        )
)
TXT;

// 显示打印的数据
echo '显示打印的数据：'.PHP_EOL;
echo $print_r_data.PHP_EOL;

$oRestorePrint = new RestorePrint;
$oRestorePrint->set('Array', 'group');
$oRestorePrint->set(' [', 'brackets,[');
$oRestorePrint->set('] => ', 'brackets,]');
$oRestorePrint->set(')', 'brackets,)');

$result = $oRestorePrint->parse($print_r_data);

echo PHP_EOL.'还原为数组：'.PHP_EOL;
var_dump($result);
```

**输出：**

```txt
显示打印的数据：
Array
(
    [name] => fdipzone
    [gender] => male
    [age] => 18
    [profession] => programmer
    [detail] => Array
        (
            [grade] => 1
            [create_time] => 2024-05-23
        )
)

还原为数组：
array(5) {
  ["name"]=>
  string(8) "fdipzone"
  ["gender"]=>
  string(4) "male"
  ["age"]=>
  string(2) "18"
  ["profession"]=>
  string(10) "programmer"
  ["detail"]=>
  array(2) {
    ["grade"]=>
    string(1) "1"
    ["create_time"]=>
    string(10) "2024-05-23"
  }
}
```
