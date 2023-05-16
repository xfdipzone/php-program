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
     * 水印圖片不透明度，0-100，越小越透明(GD库不支持)
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
     * 水印定位偏移，横坐标、纵坐标
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
     * 缩略图质量，10-100，越高质量越好
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

    /**
     * 初始化
     *
     * @author fdipzone
     * @DateTime 2023-04-21 23:07:17
     *
     * @param int $width  缩略图区域宽度
     * @param int $height 缩略图区域高度
     */
    public function __construct(int $width, int $height){
        if($width<1 || $height<1){
            throw new \Exception('width or height error');
        }
        $this->width = $width;
        $this->height = $height;
    }

    /**
     * 设置缩略图适配类型
     *
     * @author fdipzone
     * @DateTime 2023-04-21 23:10:34
     *
     * @param string $thumb_adapter_type 缩略图适配类型 在 Config\ThumbAdapterType 中定义
     * @return void
     */
    public function setThumbAdapterType(string $thumb_adapter_type):void{
        if(!Config\ThumbAdapterType::valid($thumb_adapter_type)){
            throw new \Exception('thumb adapter type error');
        }
        $this->thumb_adapter_type = $thumb_adapter_type;
    }

    /**
     * 获取缩略图适配类型
     *
     * @author fdipzone
     * @DateTime 2023-04-21 23:12:47
     *
     * @return string
     */
    public function thumbAdapterType():string{
        return $this->thumb_adapter_type;
    }

    /**
     * 设置水印图片
     *
     * @author fdipzone
     * @DateTime 2023-04-21 23:14:25
     *
     * @param string $watermark 水印图片
     * @return void
     */
    public function setWatermark(string $watermark):void{
        if(!file_exists($watermark)){
            throw new \Exception('watermark file not exists');
        }
        $this->watermark = $watermark;
    }

    /**
     * 获取水印图片
     *
     * @author fdipzone
     * @DateTime 2023-04-21 23:16:39
     *
     * @return string
     */
    public function watermark():string{
        return $this->watermark;
    }

    /**
     * 设置水印圖片不透明度
     *
     * @author fdipzone
     * @DateTime 2023-04-21 23:21:16
     *
     * @param int $watermark_opacity 水印圖片不透明度
     * @return void
     */
    public function setWatermarkOpacity(int $watermark_opacity):void{
        if($watermark_opacity<0 || $watermark_opacity>100){
            throw new \Exception('watermark opacity must be between 0 and 100');
        }
        $this->watermark_opacity = $watermark_opacity;
    }

    /**
     * 获取水印圖片不透明度
     *
     * @author fdipzone
     * @DateTime 2023-04-21 23:22:12
     *
     * @return int
     */
    public function watermarkOpacity():int{
        return $this->watermark_opacity;
    }

    /**
     * 设置水印摆放位置
     *
     * @author fdipzone
     * @DateTime 2023-04-21 23:30:10
     *
     * @param string $watermark_gravity 水印摆放位置 在 Config\WaterMarkGravity 中定义
     * @return void
     */
    public function setWatermarkGravity(string $watermark_gravity):void{
        if(!Config\WaterMarkGravity::valid($watermark_gravity)){
            throw new \Exception('watermark gravity error');
        }
        $this->watermark_gravity = $watermark_gravity;
    }

    /**
     * 获取水印摆放位置
     *
     * @author fdipzone
     * @DateTime 2023-04-21 23:31:25
     *
     * @return string
     */
    public function watermarkGravity():string{
        return $this->watermark_gravity;
    }

    /**
     * 设置水印定位偏移
     *
     * @author fdipzone
     * @DateTime 2023-04-21 23:43:26
     *
     * @param string $watermark_geometry 水印定位偏移
     * @return void
     */
    public function setWatermarkGeometry(string $watermark_geometry):void{
        $pattern = '/^[+-]\d+[+-]\d+$/';
        if(!preg_match($pattern, $watermark_geometry)){
            throw new \Exception('watermark geometry error');
        }
        $this->watermark_geometry = $watermark_geometry;
    }

    /**
     * 获取水印定位偏移
     *
     * @author fdipzone
     * @DateTime 2023-04-21 23:45:38
     *
     * @return string
     */
    public function watermarkGeometry():string{
        return $this->watermark_geometry;
    }

    /**
     * 设置裁剪位置
     *
     * @author fdipzone
     * @DateTime 2023-04-21 23:48:22
     *
     * @param string $crop_position 裁剪位置 在 Config\CropPosition 中定义
     * @return void
     */
    public function setCropPosition(string $crop_position):void{
        if(!Config\CropPosition::valid($crop_position)){
            throw new \Exception('crop position error');
        }
        $this->crop_position = $crop_position;
    }

    /**
     * 获取裁剪位置
     *
     * @author fdipzone
     * @DateTime 2023-04-22 00:05:23
     *
     * @return string
     */
    public function cropPosition():string{
        return $this->crop_position;
    }

    /**
     * 设置背景颜色
     *
     * @author fdipzone
     * @DateTime 2023-04-21 23:50:46
     *
     * @param string $bgcolor 背景颜色
     * @return void
     */
    public function setBgcolor(string $bgcolor):void{
        $this->bgcolor = $bgcolor;
    }

    /**
     * 获取背景颜色
     *
     * @author fdipzone
     * @DateTime 2023-04-21 23:51:19
     *
     * @return string
     */
    public function bgcolor():string{
        return $this->bgcolor;
    }

    /**
     * 设置缩略图质量
     *
     * @author fdipzone
     * @DateTime 2023-04-21 23:52:07
     *
     * @param int $quality 缩略图质量
     * @return void
     */
    public function setQuality(int $quality):void{
        if($quality<10 || $quality>100){
            throw new \Exception('quality must be between 10 and 100');
        }
        $this->quality = $quality;
    }

    /**
     * 获取缩略图质量
     *
     * @author fdipzone
     * @DateTime 2023-04-21 23:53:33
     *
     * @return int
     */
    public function quality():int{
        return $this->quality;
    }

    /**
     * 获取缩略图区域宽度
     *
     * @author fdipzone
     * @DateTime 2023-04-22 00:00:36
     *
     * @return int
     */
    public function width():int{
        return $this->width;
    }

    /**
     * 获取缩略图区域高度
     *
     * @author fdipzone
     * @DateTime 2023-04-22 00:00:41
     *
     * @return int
     */
    public function height():int{
        return $this->height;
    }

}