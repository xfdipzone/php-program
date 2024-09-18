<?php
namespace CssManager;

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
     * @param array $extensions 后缀集合，不需要包含 "."，例如 jpg, gif, png
     * @return boolean
     */
    public static function checkExtension(string $file, array $extensions):bool
    {
        $extension = strtolower(substr($file, strrpos($file, '.')+1));
        return in_array($extension, $extensions);
    }

    /**
     * 创建多级目录
     *
     * @author fdipzone
     * @DateTime 2024-09-15 18:13:48
     *
     * @param string $path 目录
     * @return boolean
     */
    public static function createDirs(string $path):bool
    {
        // 目录不存在
        if(!is_dir($path))
        {
            return mkdir($path, 0777, true);
        }

        return true;
    }

    /**
     * 记录日志（追加）
     *
     * @author fdipzone
     * @DateTime 2024-09-15 18:19:47
     *
     * @param string $log_file 日志文件
     * @param string $content 日志内容
     * @return void
     */
    public static function log(string $log_file, string $content):void
    {
        // 创建日志目录
        $log_path = dirname($log_file);
        self::createDirs($log_path);

        // 写入日志
        $log_data = sprintf("[%s] %s\n", date('Y-m-d H:i:s'), $content);
        file_put_contents($log_file, $log_data, FILE_APPEND);
    }

    /**
     * 遍历目录，获取目录中所有文件集合
     *
     * @author fdipzone
     * @DateTime 2024-09-15 21:46:47
     *
     * @param string $path 目录
     * @param array $result 目录中文件集合（指针）
     * @param boolean $recursive 是否遍历子目录，默认 false
     * @return array
     */
    public static function traversing(string $path, array &$result=[], bool $recursive=false):void
    {
        if($handle = opendir($path))
        {
            while(($file=readdir($handle))!==false)
            {
                if($file!='.' && $file!='..')
                {
                    $cur_file = $path.'/'.$file;

                    // folder
                    if(is_dir($cur_file))
                    {
                        // 遍历子目录
                        if($recursive)
                        {
                            self::traversing($cur_file, $result, $recursive);
                        }
                    }
                    // file
                    else
                    {
                        $result[] = $cur_file;
                    }
                }
            }

            // 关闭
            closedir($handle);
        }
    }
}