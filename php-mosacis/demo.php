<?php
/**
 * php 图片局部打马赛克
 * Date:    2020-01-10
 * Author:  fdipzone
 * Ver:     1.0
 *
 * Description
 * 原理：
 * 对图片中选定区域的每一像素，增加若干宽度及高度，生成矩型。而每一像素的矩型重叠在一起，就形成了马赛克效果。
 * 本方法使用GD库的imagecolorat获取像素颜色，使用imagefilledrectangle画矩型。
 * 
 * Func
 * imageMosaics 将原图局部打马赛克
 */

/** 图片局部打马赛克
 *
 * @param  String  $source 原图
 * @param  String  $dest   生成的图片
 * @param  int     $x1     起点横坐标
 * @param  int     $y1     起点纵坐标
 * @param  int     $x2     终点横坐标
 * @param  int     $y2     终点纵坐标
 * @param  int     $deep   深度，数字越大越模糊
 * @return boolean
 */
function imageMosaics($source, $dest, $x1, $y1, $x2, $y2, $deep){

    // 判断原图是否存在
    if(!file_exists($source)){
        return false;
    }

    // 获取原图信息
    list($owidth, $oheight, $otype) = getimagesize($source);

    // 判断区域是否超出图片
    if($x1>$owidth || $x1<0 || $x2>$owidth || $x2<0 || $y1>$oheight || $y1<0 || $y2>$oheight || $y2<0){
        return false;
    }

    switch($otype){
        case 1: $source_img = imagecreatefromgif($source); break;
        case 2: $source_img = imagecreatefromjpeg($source); break;
        case 3: $source_img = imagecreatefrompng($source); break;
        default:
            return false;
    }

    // 打马赛克
    for($x=$x1; $x<$x2; $x=$x+$deep){
        for($y=$y1; $y<$y2; $y=$y+$deep){
            $color = imagecolorat($source_img, $x+round($deep/2), $y+round($deep/2));
            imagefilledrectangle($source_img, $x, $y, $x+$deep, $y+$deep, $color);
        }
    }

    // 生成图片
    switch($otype){
        case 1: imagegif($source_img, $dest); break;
        case 2: imagejpeg($source_img, $dest); break;
        case 3: imagepng($source_img, $dest); break;
    }

    return is_file($dest)? true : false;

}

// 原图
$source = dirname(__FILE__).'/source.jpg';

// 生成效果图
$dest = dirname(__FILE__).'/dest.jpg';

$flag = imageMosaics($source, $dest, 176, 98, 273, 197, 4);
echo '<img src="'.$source.'">';
echo '<img src="'.$dest.'">';

?>