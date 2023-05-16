<?php
require 'autoload.php';

// 源图片文件
$source = dirname(__FILE__).'/pic/source.jpg';
$watermark = dirname(__FILE__).'/pic/watermark.png';

// 缩略图配置(fit)
$config = new \Thumbnail\Config(500, 380);
$config->setThumbAdapterType(\Thumbnail\Config\ThumbAdapterType::FIT);
$config->setBgcolor('#FFCC33');
$config->setQuality(85);
$config->setWatermark($watermark);
$config->setWatermarkGravity(\Thumbnail\Config\WaterMarkGravity::NORTHEAST);
$config->setWatermarkGeometry('+5+35');
$config->setWatermarkOpacity(25);

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