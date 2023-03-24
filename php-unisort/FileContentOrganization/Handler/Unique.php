<?php
namespace FileContentOrganization\Handler;

/**
 * 去重处理
 *
 * @author fdipzone
 * @DateTime 2023-03-24 20:18:40
 *
 */
class Unique implements \FileContentOrganization\IHandler{

    /**
     * 执行处理
     *
     * @author fdipzone
     * @DateTime 2023-03-24 20:19:22
     *
     * @param string $data 文件内容
     * @return string
     */
    public function handle(string $data):string{

        // 将内容按换行符分割为数组
        $rows = explode(PHP_EOL, $data);

        // 过滤空行
        $rows = array_filter($rows, function($row){
            return trim($row)!=='';
        });

        // 去重
        $rows = array_flip($rows);
        $rows = array_flip($rows);

        // 数组按换行符合拼为字符串
        return implode(PHP_EOL, $rows);

    }

}