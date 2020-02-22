# php-log

php 日志类

## 介绍

使用php开发的日志处理类，本类可自定义多种日志配置，根据标签对应配置。代码中方便调用此类进行日志记录操作。提供完整代码及演示例子，方便大家学习使用。

---

## 功能

1.自定义日志根目录及日志文件名称。

2.使用日期时间格式自定义日志目录。

3.自动创建不存在的日志目录。

4.记录不同分类的日志，例如信息日志，警告日志，错误日志。

5.可自定义日志配置，日志根据标签调用不同的日志配置。

---

## 演示

```php
<?php
require 'LOG.class.php';

define('LOG_PATH', dirname(__FILE__).'/logs');

// 总配置设定
$config = array(
    'default' => array(
        'log_path' => LOG_PATH,       // 日志根目录
        'log_file' => 'default.log',  // 日志文件
        'format' => 'Y/m/d',          // 日志自定义目录，使用日期时间定义
    ),
    'user' => array(
        'log_path' => LOG_PATH,
        'log_file' => 'user.log',
        'format' => 'Y/m/d',
    ),
    'order' => array(
        'log_path' => LOG_PATH,
        'log_file' => 'order.log',
        'format' => 'Y/m/d',
    ),
);

// 设置总配置
LOG::set_config($config);

// 调用日志类，使用默认设定
$logger = LOG::get_logger();
$logger->info('Test Add Info Log');
$logger->warn('Test Add Warn Log');
$logger->error('Test Add Error Log');

// 调用日志类，使用user设定
$logger1 = LOG::get_logger('user');
$logger1->info('Test Add User Info Log');
$logger1->warn('Test Add User Warn Log');
$logger1->error('Test Add User Error Log');

// 调用日志类，使用order设定
$logger2 = LOG::get_logger('order');
$logger2->info('Test Add Order Info Log');
$logger2->warn('Test Add Order Warn Log');
$logger2->error('Test Add Order Error Log');

// 调用日志类，设定类型不存在，使用默认设定
$logger3 = LOG::get_logger('notexists');
$logger3->info('Test Add Not Exists Info Log');
$logger3->warn('Test Add Not Exists Warn Log');
$logger3->error('Test Add Not Exists Error Log');
?>
```

查看日志文件内容

```txt
ls -lt ./logs/2017/08/27/*.log
./logs/2017/08/27/default.log
./logs/2017/08/27/order.log
./logs/2017/08/27/user.log

cat ./logs/2017/08/27/default.log
[2017-08-27 13:50:13] INFO  - Test Add Info Log
[2017-08-27 13:50:13] WARN  - Test Add Warn Log
[2017-08-27 13:50:13] ERROR - Test Add Error Log
[2017-08-27 13:50:13] INFO  notexists Test Add Not Exists Info Log
[2017-08-27 13:50:13] WARN  notexists Test Add Not Exists Warn Log
[2017-08-27 13:50:13] ERROR notexists Test Add Not Exists Error Log

cat ./logs/2017/08/27/order.log
[2017-08-27 13:50:13] INFO  order Test Add Order Info Log
[2017-08-27 13:50:13] WARN  order Test Add Order Warn Log
[2017-08-27 13:50:13] ERROR order Test Add Order Error Log

cat ./logs/2017/08/27/user.log
[2017-08-27 13:50:13] INFO  user Test Add User Info Log
[2017-08-27 13:50:13] WARN  user Test Add User Warn Log
[2017-08-27 13:50:13] ERROR user Test Add User Error Log
```
