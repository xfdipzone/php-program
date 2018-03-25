# php-qrcode
PHP创建二维码类<br><br>

## 介绍

PHP实现创建二维码类，支持设置尺寸，加入LOGO，圆角，透明度，等处理。<br>

### 实现功能如下：

1.创建二维码
2.加入logo到二维码中
3.logo可描边
4.logo可圆角
5.logo可设透明度
6.logo图片及输出图片类型支持png,jpg,gif格式
7.可设置输出图片质量

### 设定参数说明：

ecc
二维码质量 L-smallest, M, Q, H-best

size
二维码尺寸 1-50

dest_file
生成的二维码图片路径

quality
生成的图片质量

logo
logo路径，为空表示不加入logo

logo_size
logo尺寸，null表示按二维码尺寸比例自动计算

logo_outline_size
logo描边尺寸，null表示按logo尺寸按比例自动计算

logo_outline_color
logo描边颜色

logo_opacity
logo不透明度 0-100

logo_radius
logo圆角角度 0-30

## 演示

```php
<?php
require 'PHPQRCode.class.php';

$config = array(
        'ecc' => 'H',    // L-smallest, M, Q, H-best
        'size' => 12,    // 1-50
        'dest_file' => 'qrcode.png',
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
$oPHPQRCode = new PHPQRCode();

// 设定配置
$oPHPQRCode->set_config($config);

// 创建二维码
$qrcode = $oPHPQRCode->generate($data);

// 显示二维码
echo '<img src="'.$qrcode.'?t='.time().'">';
?>
```

生成的二维码图片：

![二维码](https://github.com/xfdipzone/Small-Program/blob/master/php-qrcode/qrcode.png)
