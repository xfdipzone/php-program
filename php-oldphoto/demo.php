<?php
/**
 * php 调用imagemagick实现老照片效果 
 * Date:    2016-12-31
 * Author:  fdipzone
 * Ver:     1.0
 *
 * Func
 * createOldPhoto 将原图处理为老照片效果
 */

/**
 * 调用imagemagick实现老照片效果
 * @param String $source 原图
 * @param String $dest   目的图
 */
function createOldPhoto($source, $dest){

    // 命令行
    $cmd = sprintf("convert '%s' -sepia-tone '75%%' \( '%s' -fill '#FFFFFF' -colorize '100%%' +noise Random -colorspace gray -alpha on -channel A -evaluate Set 100 \) -compose overlay -composite '%s'", $source, $source, $dest);

    // 执行命令
    exec($cmd);

}

// 原图
$source = dirname(__FILE__).'/source.jpg';

// 生成效果图
$dest = dirname(__FILE__).'/dest.jpg';

// 创建效果图
createOldPhoto($source, $dest);

// 显示原图与效果图比较
echo '<meta http-equiv="content-type" content="text/html;charset=utf-8">';
echo '<p>原图</p>';
echo '<p><img src="'.basename($source).'"></p>';

echo '<p>效果图</p>';
echo '<p><img src="'.basename($dest).'"></p>';

?>