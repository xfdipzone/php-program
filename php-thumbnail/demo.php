<?php
require 'autoload.php';

// 源图片文件
$source = dirname(__FILE__).'/source.jpg';

// 缩略图配置
$config = new \Thumbnail\Config;

// 缩略图处理类(ImageMagick)
$imagemagick_handler = \Thumbnail\Factory::make(\Thumbnail\Type::IMAGEMAGICK, $config);

// 缩略图文件
$thumb = dirname(__FILE__).'/imagemagick_thumb.jpg';
$response = $imagemagick_handler->create($source, $thumb);
var_dump($response);

// 缩略图处理类(GD库)
$gd_handler = \Thumbnail\Factory::make(\Thumbnail\Type::GD, $config);
$thumb = dirname(__FILE__).'/gd_thumb.jpg';
$response = $gd_handler->create($source, $thumb);
var_dump($response);