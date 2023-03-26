<?php
require 'LOG.php';

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