<?php
namespace CssUpdater;

/**
 * 通用方法集合
 *
 * @author fdipzone
 * @DateTime 2024-09-14 16:46:03
 *
 */
class Utils
{
    /**
     * 检查文件是否指定的后缀
     *
     * @author fdipzone
     * @DateTime 2024-09-14 18:22:07
     *
     * @param string $file 文件
     * @param array $extensions 后缀集合
     * @return boolean
     */
    public static function checkExtension(string $file, array $extensions):bool
    {
        $extension = strtolower(substr($file, strrpos($file, '.')+1));
        return in_array($extension, $extensions);
    }
}