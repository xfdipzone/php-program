<?php
namespace ExportCsv;

/**
 * 格式化导出数据为csv
 *
 * @author fdipzone
 * @DateTime 2023-05-29 22:27:13
 *
 */
class ExportFormatter
{
    /**
     * 格式化数据为csv
     *
     * @author fdipzone
     * @DateTime 2023-05-29 22:28:43
     *
     * @param array $data 数据集合
     * @param string $separator 分隔符
     * @param string $delimiter 定界符
     * @return string
     */
    public static function format(array $data, string $separator, string $delimiter):string
    {
        // 定义转义处理
        $escape = function(string $str) use ($delimiter)
        {
            return str_replace($delimiter, $delimiter.$delimiter, $str);
        };

        // 对数组每个元素进行转义
        $data = array_map($escape, $data);
        return $delimiter.implode($delimiter.$separator.$delimiter, $data).$delimiter."\r\n";
    }
}