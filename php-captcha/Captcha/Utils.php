<?php
namespace Captcha;

/**
 * 通用方法集合
 *
 * @author fdipzone
 * @DateTime 2023-08-23 12:30:51
 *
 */
class Utils
{
    /**
     * 16进制颜色格式转换为RGB颜色格式
     * 例如: #FFFFFF -> 255,255,255, #FFF -> 255,255,255
     *
     * @author fdipzone
     * @DateTime 2023-08-23 12:30:55
     *
     * @param string $hex_color 16进制颜色格式
     * @return array
     */
    public static function hexToRGB(string $hex_color):array
    {
        $color = str_replace('#', '', $hex_color);

        // 6位16进制颜色
        if(strlen($color)==6)
        {
            $rgb = array(
                'r' => hexdec(substr($color, 0, 2)),
                'g' => hexdec(substr($color, 2, 2)),
                'b' => hexdec(substr($color, 4, 2))
            );
        }
        // 3位16进制颜色
        elseif(strlen($color)==3)
        {
            $r = substr($color, 0, 1).substr($color, 0, 1);
            $g = substr($color, 1, 1).substr($color, 1, 1);
            $b = substr($color, 2, 1).substr($color, 2, 1);
            $rgb = array(
                'r' => hexdec($r),
                'g' => hexdec($g),
                'b' => hexdec($b)
            );
        }
        // 非16进制颜色格式
        else
        {
            throw new \Exception('hex color:'.$hex_color.' error');
        }

        return $rgb;
    }

    /**
     * 判断点是否在圆范围内
     *
     * @author fdipzone
     * @DateTime 2023-08-23 16:20:49
     *
     * @param int $px 点x坐标
     * @param int $py 点y坐标
     * @param int $cx 圆心x坐标
     * @param int $cy 圆心y坐标
     * @param int $cr 圆半径
     * @return boolean
     */
    public static function pointInArea(int $px, int $py, int $cx, int $cy, int $cr):bool
    {
        // 通过计算点与圆心距离是否<圆半径，判断点是否在圆范围内
        $x = $cx - $px;
        $y = $cy - $py;
        return round(sqrt($x*$x + $y*$y))<$cr;
    }
}