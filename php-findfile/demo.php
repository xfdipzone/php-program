<?php
require 'AbstractFindFile.php';
require 'UnsetUtf8Bom.php';
require 'TestUtil.php';

define('ROOT_PATH', dirname(__FILE__));

$source = ROOT_PATH.'/test_data';
$test_folder = ROOT_PATH.'/test_data/result';

// 将测试文件复制到测试目录
InitTestData($source, $test_folder);

$file_type = array('txt', 'css', 'js');
$oUnsetUtf8Bom = new UnsetUtf8Bom($file_type);

// 遍历所有子文件夹，会处理sub_folder内文件
$oUnsetUtf8Bom->find($test_folder);

// 设置搜索深度为1，不会处理sub_folder内文件 
//$oUnsetUtf8Bom->find($test_folder, 1); 

$response = $oUnsetUtf8Bom->response();

print_r($oUnsetUtf8Bom->response());