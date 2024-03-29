<?php
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