<?php
require 'autoload.php';

// 源文件及目标文件
$source = '/tmp/user_id.txt';
$dest = '/tmp/php_sort_user_id.txt';

// 写入10000个数字，每行一个数字
$num = 10000;
$tmp = '';

// 生成测试数据
file_put_contents($source, '', true);
for($i=0; $i<$num; $i++){
    $tmp .= mt_rand(0,999).PHP_EOL;
    if($i>0 && $i%1000==0 || $i==$num-1){
        file_put_contents($source, $tmp, FILE_APPEND);
        $tmp = '';
    }
}

// 创建处理器对象
$unique_handler = \FileContentOrganization\Factory::make(\FileContentOrganization\Type::UNIQUE);

$sort_handler = \FileContentOrganization\Factory::make(\FileContentOrganization\Type::SORT);
$sort_handler->setOrder('desc');
$sort_handler->setSortFlag(SORT_NUMERIC);

// 创建文件内容整理对象
$organizer = new \FileContentOrganization\Organizer($source, $dest);
$organizer->addHandler($unique_handler);
$organizer->addHandler($sort_handler);
$organizer->handle();
?>