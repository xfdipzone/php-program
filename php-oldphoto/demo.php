<?php
require 'OldPhotoEffect.php';

// 原图
$source = dirname(__FILE__).'/source.jpg';

// 生成效果图
$dest = dirname(__FILE__).'/dest.jpg';

// 创建效果图
$is_create = OldPhotoEffect::create($source, $dest);

// 显示原图与效果图比较
if($is_create)
{
    echo '<meta http-equiv="content-type" content="text/html;charset=utf-8">';
    echo '<p>原图</p>';
    echo '<p><img src="'.basename($source).'"></p>';

    echo '<p>效果图</p>';
    echo '<p><img src="'.basename($dest).'"></p>';
}
?>