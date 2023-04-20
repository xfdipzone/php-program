<?php
namespace Thumbnail;

/**
 * 定义支持生成缩略图的组件类型
 *
 * @author fdipzone
 * @DateTime 2023-04-10 21:37:02
 *
 */
class Type{

    // 基于imagemagick
    const IMAGEMAGICK = 'imagemagick';

    // 基于GD库
    const GD = 'gd';

    // 类型与实现类对应关系
    public static $lookup = [
        self::IMAGEMAGICK => 'Thumbnail\\ImageMagick',
        self::GD => 'Thumbnail\\GD'
    ];

}