<?php
/**
 * php 图片局部打马赛克
 *
 * @author fdipzone
 * @DateTime 2023-04-05 21:32:02
 *
 * Description:
 * 原理：
 * 对图片中选定区域的每一像素，增加若干宽度及高度，生成矩型。而每一像素的矩型重叠在一起，就形成了马赛克效果。
 * 本方法使用GD库的imagecolorat获取像素颜色，使用imagefilledrectangle画矩型。
 *
 * Func:
 * create 将原图局部打马赛克，生成效果图
 * validateConfig 检查配置
 * fileExt 根据文件后缀获取文件类型
 */
class MosaicsEffect{

    /**
     * 生成效果图
     *
     * @author fdipzone
     * @DateTime 2023-04-05 21:39:52
     *
     * @param string $source 原图
     * @param string $dest   效果图
     * @param array $config  配置 ['start_x'=>xx, 'start_y'=>xx, 'end_x'=>xx, 'end_y'=>xx, 'deep'=>xx]
     * @return boolean
     */
    public static function create(string $source, string $dest, array $config):bool{

        try{
            // 判断原图是否存在
            if(!file_exists($source)){
                throw new \Exception('source not exists');
            }

            // 检查配置
            self::validateConfig($config);

            // 获取原图信息
            list($width, $height, $type) = getimagesize($source);

            // 判断区域是否超出图片
            if($config['start_x']>$width || $config['end_x']>$width || $config['start_y']>$height || $config['end_y']>$height){
                throw new \Exception('config start_x,start_y,end_x,end_y exceeds the image range');
            }

            switch($type){
                case 1: $source_img = imagecreatefromgif($source); break;
                case 2: $source_img = imagecreatefromjpeg($source); break;
                case 3: $source_img = imagecreatefrompng($source); break;
                default:
                    throw new \Exception('source type not supported');
            }

            // 打马赛克
            for($x=$config['start_x']; $x<$config['end_x']; $x=$x+$config['deep']){
                for($y=$config['start_y']; $y<$config['end_y']; $y=$y+$config['deep']){
                    $color = imagecolorat($source_img, $x+round($config['deep']/2), $y+round($config['deep']/2));
                    imagefilledrectangle($source_img, $x, $y, $x+$config['deep'], $y+$config['deep'], $color);
                }
            }

            // 生成图片
            $dest_ext = self::fileExt($dest);

            switch($dest_ext){
                case 1: imagegif($source_img, $dest); break;
                case 2: imagejpeg($source_img, $dest); break;
                case 3: imagepng($source_img, $dest); break;
                default:
                    throw new \Exception('dest type not supported');
            }

            return is_file($dest)? true : false;

        }catch(\Throwable $e){
            throw new \Exception($e->getMessage());
        }

    }

    /**
     * 检查配置是否正确
     *
     * @author fdipzone
     * @DateTime 2023-04-05 21:46:05
     *
     * @param array $config 配置
     * @return boolean
     */
    private static function validateConfig(array $config):bool{

        // 检查配置
        if(!isset($config['start_x']) || !is_int($config['start_x']) || $config['start_x']<0){
            throw new \Exception('config start_x error');
        }

        if(!isset($config['start_y']) || !is_int($config['start_y']) || $config['start_y']<0){
            throw new \Exception('config start_x error');
        }

        if(!isset($config['end_x']) || !is_int($config['end_x']) || $config['end_x']<0){
            throw new \Exception('config end_x error');
        }

        if(!isset($config['end_y']) || !is_int($config['end_y']) || $config['end_y']<0){
            throw new \Exception('config start_x error');
        }

        if(!isset($config['deep']) || !is_int($config['deep']) || $config['deep']<0){
            throw new \Exception('config deep error');
        }

        return true;

    }

    /**
     * 获取图片类型
     *
     * @author fdipzone
     * @DateTime 2023-04-05 22:16:30
     *
     * @param string $file
     * @return int
     */
    private static function fileExt(string $file):int{
        $filename = basename($file);
        list($name, $ext)= explode('.', $filename);

        $ext_type = 0;

        switch(strtolower($ext)){
            case 'jpg':
            case 'jpeg':
                $ext_type = 2;
                break;
            case 'gif':
                $ext_type = 1;
                break;
            case 'png':
                $ext_type = 3;
                break;
        }

        return $ext_type;
    }

}