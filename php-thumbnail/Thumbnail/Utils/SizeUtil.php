<?php
namespace Thumbnail\Utils;

/**
 * 计算缩略图尺寸相关方法集合
 *
 * @author fdipzone
 * @DateTime 2023-05-13 20:55:18
 *
 */
class SizeUtil{
    
    /**
     * 计算缩略图尺寸
     *
     * @author fdipzone
     * @DateTime 2023-05-12 21:58:00
     *
     * @param string $thumb_adapter_type 缩略图适配类型 在 \Thumbnail\Config\ThumbAdapterType 中定义
     * @param int $o_width 源图片宽度
     * @param int $o_height 源图片高度
     * @param int $width 区域宽度
     * @param int $height 区域高度
     * @return array thumb_width,thumb_height
     */
    public static function thumbSize(string $thumb_adapter_type, int $o_width, int $o_height, int $width, int $height):array{
        // 检查缩略图适配类型
        if(!\Thumbnail\Config\ThumbAdapterType::valid($thumb_adapter_type)){
            throw new \Exception('thumb adapter type error');
        }

        // 计算缩略图尺寸
        switch($thumb_adapter_type){
            // fit
            case \Thumbnail\Config\ThumbAdapterType::FIT:
                $thumb_width = $width;
                $thumb_height = (int)($thumb_width*$o_height/$o_width);
                if($thumb_height>$height){
                    $thumb_height = $height;
                    $thumb_width = (int)($thumb_height*$o_width/$o_height);
                }
                break;

            // crop
            case \Thumbnail\Config\ThumbAdapterType::CROP:
                $thumb_width = $width;
                $thumb_height = (int)($thumb_width*$o_height/$o_width);
                if($thumb_height<$height){
                    $thumb_height = $height;
                    $thumb_width = (int)($thumb_height*$o_width/$o_height);
                }
                break;
        }

        return array($thumb_width, $thumb_height);
    }

    /**
     * 计算裁剪偏移量
     *
     * @author fdipzone
     * @DateTime 2023-05-12 22:19:53
     *
     * @param string $crop_position 裁剪位置 在 \Thumbnail\Config\CropPosition 中定义
     * @param int $p_width 图片宽度
     * @param int $p_height 图片高度
     * @param int $width 区域宽度
     * @param int $height 区域高度
     * @return array offset_w,offset_h
     */
    public static function cropOffset(string $crop_position, int $p_width, int $p_height, int $width, int $height):array{
        // 检查裁剪位置
        if(!\Thumbnail\Config\CropPosition::valid($crop_position)){
            throw new \Exception('crop position error');
        }

        // 计算裁剪偏移量
        switch($crop_position){
            case \Thumbnail\Config\CropPosition::TL:
                $offset_w = 0;
                $offset_h = 0;
                break;

            case \Thumbnail\Config\CropPosition::TM:
                $offset_w = (int)(($p_width-$width)/2);
                $offset_h = 0;
                break;

            case \Thumbnail\Config\CropPosition::TR:
                $offset_w = (int)($p_width-$width);
                $offset_h = 0;
                break;

            case \Thumbnail\Config\CropPosition::ML:
                $offset_w = 0;
                $offset_h = (int)(($p_height-$height)/2);
                break;

            case \Thumbnail\Config\CropPosition::MM:
                $offset_w = (int)(($p_width-$width)/2);
                $offset_h = (int)(($p_height-$height)/2);
                break;

            case \Thumbnail\Config\CropPosition::MR:
                $offset_w = (int)($p_width-$width);
                $offset_h = (int)(($p_height-$height)/2);
                break;

            case \Thumbnail\Config\CropPosition::BL:
                $offset_w = 0;
                $offset_h = (int)($p_height-$height);
                break;

            case \Thumbnail\Config\CropPosition::BM:
                $offset_w = (int)(($p_width-$width)/2);
                $offset_h = (int)($p_height-$height);
                break;

            case \Thumbnail\Config\CropPosition::BR:
                $offset_w = (int)($p_width-$width);
                $offset_h = (int)($p_height-$height);
                break;
        }

        return array($offset_w, $offset_h);
    }

    /**
     * 计算水印图片摆放坐标
     *
     * @author fdipzone
     * @DateTime 2023-05-13 21:09:20
     *
     * @param string $watermark_gravity 水印摆放位置 在 \Thumbnail\Config\WaterMarkGravity 中定义
     * @param int $p_width 图片宽度
     * @param int $p_height 图片高度
     * @param int $watermark_width 水印图宽度
     * @param int $watermark_height 水印图高度
     * @return array position_x,position_y
     */
    public static function watermarkPosition(string $watermark_gravity, int $p_width, int $p_height, int $watermark_width, int $watermark_height):array{
        // 检查水印摆放位置
        if(!\Thumbnail\Config\WaterMarkGravity::valid($watermark_gravity)){
            throw new \Exception('watermark gravity error');
        }

        // 计算水印图片摆放坐标
        switch($watermark_gravity){
            case \Thumbnail\Config\WaterMarkGravity::NORTHWEST:
                $position_x = 0;
                $position_y = 0;
                break;

            case \Thumbnail\Config\WaterMarkGravity::NORTH:
                $position_x = ($p_width - $watermark_width) / 2;
                $position_y = 0;
                break;

            case \Thumbnail\Config\WaterMarkGravity::NORTHEAST:
                $position_x = $p_width - $watermark_width;
                $position_y = 0;
                break;

            case \Thumbnail\Config\WaterMarkGravity::WEST:
                $position_x = 0;
                $position_y = ($p_height - $watermark_height) / 2;
                break;

            case \Thumbnail\Config\WaterMarkGravity::CENTER:
                $position_x = ($p_width - $watermark_width) / 2;
                $position_y = ($p_height - $watermark_height) / 2;
                break;

            case \Thumbnail\Config\WaterMarkGravity::EAST:
                $position_x = $p_width - $watermark_width;
                $position_y = ($p_height - $watermark_height) / 2;
                break;

            case \Thumbnail\Config\WaterMarkGravity::SOUTHWEST:
                $position_x = 0;
                $position_y = $p_height - $watermark_height;
                break;

            case \Thumbnail\Config\WaterMarkGravity::SOUTH:
                $position_x = ($p_width - $watermark_width) / 2;
                $position_y = $p_height - $watermark_height;
                break;

            case \Thumbnail\Config\WaterMarkGravity::SOUTHEAST:
                $position_x = $p_width - $watermark_width;
                $position_y = $p_height - $watermark_height;
                break;
        }

        return array($position_x, $position_y);
    }

}