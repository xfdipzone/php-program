<?php
/**
 * php调用imagemagick实现老照片效果
 *
 * @author fdipzone
 * @DateTime 2023-03-19 11:30:23
 *
 */
class OldPhotoEffect{

    /**
     * 生成老照片效果图
     *
     * @author fdipzone
     * @DateTime 2023-03-19 11:31:30
     *
     * @param string $source 原图
     * @param string $dest   老照片效果图
     * @return boolean
     */
    public static function create(string $source, string $dest):bool{

        // 判断原图是否存在
        if(!file_exists($source)){
            throw new \Exception('source file not exists');
        }

        // 命令行
        $cmd = sprintf("convert '%s' -sepia-tone '75%%' \( '%s' -fill '#FFFFFF' -colorize '100%%' +noise Random -colorspace gray -alpha on -channel A -evaluate Set 100 \) -compose overlay -composite '%s'", $source, $source, $dest);

        // 执行命令
        exec($cmd);

        // 判断是否创建成功
        return file_exists($dest)? true : false;

    }

}