<?php
require 'QRCodeGenerator.php';

$config = array(
        'ecc' => 'H',    // L-smallest, M, Q, H-best
        'size' => 12,    // 1-50
        'dest_file' => 'qr_code.png',
        'quality' => 90,
        'logo' => 'logo.jpg',
        'logo_size' => 100,
        'logo_outline_size' => 20,
        'logo_outline_color' => '#FFFF00',
        'logo_radius' => 15,
        'logo_opacity' => 100,
);

// 二维码内容
$data = 'http://weibo.com/fdipzone';

// 创建二维码类
$generator = new QRCodeGenerator();

// 设定配置
$generator->set_config($config);

// 创建二维码
$qr_code = $generator->generate($data);

// 显示二维码
echo '<img src="'.$qr_code.'?t='.time().'">';
?>