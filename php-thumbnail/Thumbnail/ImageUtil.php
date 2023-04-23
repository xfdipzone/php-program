<?php
namespace Thumbnail;

/**
 * 创建缩略图相关通用方法集合
 *
 * @author fdipzone
 * @DateTime 2023-04-23 16:00:38
 *
 */
class ImageUtil{

    /**
     * 创建文件目录
     *
     * @author fdipzone
     * @DateTime 2023-04-23 16:03:31
     *
     * @param string $file 文件
     * @return boolean
     */
    public static function createDirs(string $file):bool{
        $folder = dirname($file);

        // 文件目录不存在，创建文件目录
        if(!is_dir($folder)){
            return mkdir($folder, 0777, true);
        }

        return true;
    }

    /**
     * 检查图片处理器是否已安装
     *
     * @author fdipzone
     * @DateTime 2023-04-23 16:12:51
     *
     * @param string $image_handler_type 图片处理器类型 在 Type 中定义
     * @return boolean
     */
    public static function checkImageHandlerInstalled(string $image_handler_type):bool{
        switch($image_handler_type){
            case Type::IMAGEMAGICK:
                // 检查是否已安装ImageMagick
                return strstr(shell_exec('convert -version'),'Version: ImageMagick')!=''? true : false;
                break;
            case Type::GD:
                // 检查是否已安装GD库
                return function_exists('gd_info')? true : false;
                break;
            default:
                return false;
        }
    }

    /**
     * 16进制颜色格式转换为RGB颜色格式
     * 例如: #FFFFFF -> 255,255,255, #FFF -> 255,255,255
     *
     * @author fdipzone
     * @DateTime 2023-04-23 16:43:14
     *
     * @param string $hex_color 16进制颜色格式
     * @return array
     */
    public static function hexToRGB(string $hex_color):array{
        $color = str_replace('#', '', $hex_color);

        // 6位16进制颜色
        if(strlen($color)==6){
            $rgb = array(
                'r' => hexdec(substr($color, 0, 2)),
                'g' => hexdec(substr($color, 2, 2)),
                'b' => hexdec(substr($color, 4, 2))
            );
        // 3位16进制颜色
        }elseif(strlen($color)==3){
            $r = substr($color, 0, 1).substr($color, 0, 1);
            $g = substr($color, 1, 1).substr($color, 1, 1);
            $b = substr($color, 2, 1).substr($color, 2, 1);
            $rgb = array(
                'r' => hexdec($r),
                'g' => hexdec($g),
                'b' => hexdec($b)
            );
        // 非16进制颜色格式
        }else{
            throw new \Exception('hex color:'.$hex_color.' error');
        }

        return $rgb;
    }

    /**
     * 获取图片文件类型
     * 图片类型列表：https://www.php.net/manual/zh/function.image-type-to-mime-type.php
     * 此方法只支持常用的图片类型(gif,jpg,jpeg,png)，其他图片类型暂不支持
     *
     * @author fdipzone
     * @DateTime 2023-04-23 21:35:16
     *
     * @param string $image_file 图片文件
     * @return int
     */
    public static function imageFileType(string $image_file):int{
        if(file_exists($image_file)){
            // 文件存在，使用文件头获取类型
            $info = getimagesize($image_file);
            $extension = image_type_to_extension($info[2], false);
        }else{
            // 文件不存在，使用文件后缀获取类型
            $extension = substr($image_file, strrpos($image_file, '.')+1);
        }

        $image_type = 0;

        switch(strtolower($extension)){
            case 'gif':
                $image_type = IMAGETYPE_GIF;
                break;

            case 'jpg':
            case 'jpeg':
                $image_type = IMAGETYPE_JPEG;
                break;

            case 'png':
                $image_type = IMAGETYPE_PNG;
                break;
        }

        return $image_type;
    }

    /**
     * 根据图片文件创建GDImage对象
     *
     * @author fdipzone
     * @DateTime 2023-04-23 22:12:11
     *
     * @param string $image_file 图片文件
     * @return \GDImage
     */
    public static function imageCreateFromFile(string $image_file){
        $image_type = self::imageFileType($image_file);
        $image = false;
        switch($image_type){
            case IMAGETYPE_GIF:
                $image = imagecreatefromgif($image_file);
                break;
            case IMAGETYPE_JPEG:
                $image = imagecreatefromjpeg($image_file);
                break;
            case IMAGETYPE_PNG:
                $image = imagecreatefrompng($image_file);
                break;
            default:
                throw new \Exception('image type is not supported');
        }
        return $image;
    }

    /**
     * 根据GDImage创建图片文件
     *
     * @author fdipzone
     * @DateTime 2023-04-23 22:13:29
     *
     * @param \GDImage $image    GDImage对象
     * @param string $image_file 图片文件
     * @param int $quality       图片质量
     * @return boolean
     */
    public static function imageFile($image, string $image_file, int $quality):bool{
        $image_type = self::imageFileType($image_file);
        $result = false;
        switch($image_type){
            case IMAGETYPE_GIF:
                $result = imagegif($image, $image_file);
                break;
            case IMAGETYPE_JPEG:
                $result = imagejpeg($image, $image_file, $quality);
                break;
            case IMAGETYPE_PNG:
                $result = imagepng($image, $image_file, (int)(($quality-1)/10));
                break;
            default:
                throw new \Exception('image type is not supported');
        }
        return $result;
    }

    /**
     * 记录调试日志
     *
     * @author fdipzone
     * @DateTime 2023-04-23 22:44:25
     *
     * @param string $log_file 日志文件
     * @param string $msg 调试日志内容
     * @return void
     */
    public static function debug(string $log_file, string $msg):void{
        $log_content = '['.date('Y-m-d H:i:s').'] '.$msg.PHP_EOL;
        file_put_contents($log_file, $log_content, FILE_APPEND);
    }

}