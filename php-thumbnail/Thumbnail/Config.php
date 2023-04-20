<?php
namespace Thumbnail;

/**
 * 缩略图参数配置类
 *
 * @author fdipzone
 * @DateTime 2023-04-10 21:42:03
 *
 */
class Config{

    /**
     * 缩略图适配类型
     *
     * @var string
     */
    private $thumb_adapter_type = Config\ThumbAdapterType::FIT;

    /**
     * 水印图片
     *
     * @var string
     */
    private $watermark = '';

    /**
     * 水印圖片不透明度,越小越透明(GD库不支持)
     *
     * @var int
     */
    private $watermark_opacity = 75;

    /**
     * 水印摆放位置
     *
     * @var string
     */
    private $watermark_gravity = Config\WaterMarkGravity::SOUTHEAST;

    /**
     * 水印定位偏移，横坐标、纵坐标(GD库不支持)
     *
     * @var string
     */
    private $watermark_geometry = '+10+10';

    /**
     * 裁剪位置，当thumb_adapter_type=ThumbAdapterType::CROP时生效
     *
     * @var string
     */
    private $crop_position = Config\CropPosition::TL;

    /**
     * 背景颜色（16进制颜色）
     * 例：#FFFFFF
     *
     * @var string
     */
    private $bgcolor = '';

    /**
     * 缩略图质量，1-100，越高质量越好
     *
     * @var int
     */
    private $quality = 90;

    /**
     * 缩略图区域宽度
     *
     * @var int
     */
    private $width = -1;

    /**
     * 缩略图区域高度
     *
     * @var int
     */
    private $height = -1;

}