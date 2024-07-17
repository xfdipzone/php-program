# php-timezone-conversion

php 时区转换类

## 介绍

php 实现的时区转换类，将日期时间转为指定时区的日期时间，并支持时间戳转换为指定时区的日期时间

---

## 功能

- 日期时间时区转换

  将原始日期时间转为指定时区的日期时间

- 时间戳时区转换

  将时间戳转换为指定时区的日期时间

---

## 演示

```php
require 'TimeZoneConversion.php';

// 日期时间时区转换
$resp = TimeZoneConversion::convert('2024-07-15 21:00:00', 'GMT+0800', 'GMT+0700', 'Y-m-d H:i:s');
print_r($resp);

// 时间戳时区转换
$resp = TimeZoneConversion::timestampConvert(1721120701, 'GMT+0700', 'Y/m/d/ H:i:s');
echo $resp.PHP_EOL;
```
