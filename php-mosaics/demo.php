<?php
require 'MosaicsEffect.php';

// 原图
$source = dirname(__FILE__).'/source.jpg';

// 生成效果图
$dest = dirname(__FILE__).'/dest.jpg';

// 配置
$config = array(
    'start_x' => 176,
    'start_y' => 98,
    'end_x' => 273,
    'end_y' => 197,
    'deep' => 4
);

MosaicsEffect::create($source, $dest, $config);
echo '<img src="'.$source.'">';
echo '<img src="'.$dest.'">';
?>