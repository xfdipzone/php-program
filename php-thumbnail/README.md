# php-thumbnail

php 缩略图生成类

## 介绍

使用php开发的缩略图生成类，基于 `ImageMagick` 与 `GD` 库两种方式实现，用于创建图片缩略图。

支持图片自适应缩略/拉伸，裁剪，添加水印等处理。

---

## 功能

主要功能如下：

- 支持 `ImageMagick` 与 `GD` 库处理（检查系统是否有安装指定的组件）

- 按比例缩略/拉伸图片(fit)

- 按区域大小裁剪图片(crop)

  - 设置裁剪方向（例如：顶部左侧位置，底部右侧位置等）

- 添加水印

  - 设置水印位置（例如：NorthWest，West, SouthEast等）

  - 设置水印偏移

  - 设置水印透明度（GD库不支持）

    GD库不支持透明度水印，如果必须使用透明水印，请将水印图片做成有透明度

- 设置填充背景颜色

- 设置图片质量（10-100）

- 支持的图片格式 `gif`, `jpg`, `jpeg`, `png`

- `CMYK` 模式转 `RGB` 模式

---

## 演示

```php
require 'autoload.php';

// 源图片文件
$source = dirname(__FILE__).'/pic/source.jpg';

// 水印图片
$watermark = dirname(__FILE__).'/pic/watermark.png';

// 日志文件
$log_file = '/tmp/image-thumbnail.log';

// 缩略图配置(fit)
$config = new \Thumbnail\Config(500, 380);
$config->setThumbAdapterType(\Thumbnail\Config\ThumbAdapterType::FIT);
$config->setBgcolor('#FFCC33');
$config->setQuality(85);
$config->setWatermark($watermark);
$config->setWatermarkGravity(\Thumbnail\Config\WaterMarkGravity::NORTHEAST);
$config->setWatermarkGeometry('+5+35');
$config->setWatermarkOpacity(25);
$config->setLogFile($log_file);

// 缩略图处理类(ImageMagick)
$imagemagick_handler = \Thumbnail\Factory::make(\Thumbnail\Type::IMAGEMAGICK, $config);
$thumb = dirname(__FILE__).'/pic/imagemagick_fit_thumb.jpg';
$response = $imagemagick_handler->create($source, $thumb);
echo 'success='.$response->success().PHP_EOL;
if(!$response->success()){
    echo 'error='.$response->errMsg().PHP_EOL;
}
echo $response->thumb().PHP_EOL.PHP_EOL;

// 缩略图处理类(GD库)
$gd_handler = \Thumbnail\Factory::make(\Thumbnail\Type::GD, $config);
$thumb = dirname(__FILE__).'/pic/gd_fit_thumb.jpg';
$response = $gd_handler->create($source, $thumb);
echo 'success='.$response->success().PHP_EOL;
if(!$response->success()){
    echo 'error='.$response->errMsg().PHP_EOL;
}
echo $response->thumb().PHP_EOL.PHP_EOL;

// 缩略图配置(crop)
$config = new \Thumbnail\Config(400, 200);
$config->setThumbAdapterType(\Thumbnail\Config\ThumbAdapterType::CROP);
$config->setCropPosition(\Thumbnail\Config\CropPosition::MM);
$config->setQuality(85);
$config->setWatermark($watermark);
$config->setWatermarkGravity(\Thumbnail\Config\WaterMarkGravity::NORTHEAST);
$config->setWatermarkGeometry('+5+5');
$config->setWatermarkOpacity(35);
$config->setLogFile($log_file);

// 缩略图处理类(ImageMagick)
$imagemagick_handler = \Thumbnail\Factory::make(\Thumbnail\Type::IMAGEMAGICK, $config);
$thumb = dirname(__FILE__).'/pic/imagemagick_crop_thumb.jpg';
$response = $imagemagick_handler->create($source, $thumb);
echo 'success='.$response->success().PHP_EOL;
if(!$response->success()){
    echo 'error='.$response->errMsg().PHP_EOL;
}
echo $response->thumb().PHP_EOL.PHP_EOL;

// 缩略图处理类(GD库)
$gd_handler = \Thumbnail\Factory::make(\Thumbnail\Type::GD, $config);
$thumb = dirname(__FILE__).'/pic/gd_crop_thumb.jpg';
$response = $gd_handler->create($source, $thumb);
echo 'success='.$response->success().PHP_EOL;
if(!$response->success()){
    echo 'error='.$response->errMsg().PHP_EOL;
}
echo $response->thumb().PHP_EOL.PHP_EOL;
```
