<?php
/**
 * 初始化测试数据
 * 复制测试文件到测试目录
 *
 * @author fdipzone
 * @DateTime 2023-08-01 22:10:17
 *
 * @param string $source      测试源数据目录
 * @param string $test_folder 测试目录
 * @return void
 */
function InitTestData(string $source, string $test_folder):void
{
    // 测试使用的文件列表
    $test_files = array('test.txt', 'test_no_bom.txt', 'test.css', 'test.js', 'test.log');

    // 创建子文件夹
    if(!is_dir($test_folder.'/sub_folder'))
    {
        mkdir($test_folder.'/sub_folder', 0777, true);
    }

    // 先将原来测试目录文件删除，再重新复制
    foreach($test_files as $test_file)
    {
        // 删除已有文件
        if(file_exists($test_folder.'/'.$test_file))
        {
            unlink($test_folder.'/'.$test_file);
        }

        if(file_exists($test_folder.'/sub_folder/'.$test_file))
        {
            unlink($test_folder.'/sub_folder/'.$test_file);
        }

        // 重新复制文件
        copy($source.'/'.$test_file, $test_folder.'/'.$test_file);
        copy($source.'/sub_folder/'.$test_file, $test_folder.'/sub_folder/'.$test_file);
    }
}