<?php
/**
 * 字符编码转换器
 * 支持ANSI、UTF-16、UTF-16 Big Endian、UTF-8、UTF-8+Bom编码的数据互相转换
 *
 * @author fdipzone
 * @DateTime 2023-06-29 23:55:15
 *
 */
class CharsetConvertor
{
    // 定义支持转换的字符集编码类型
    const ANSI = 'ansi';

    const UTF8 = 'utf8';

    const UTF8BOM = 'utf8-bom';

    const UTF16 = 'utf16';

    const UTF16BE = 'utf16-be';

    /**
     * 执行转换(根据输入字符集编码与输出字符集编码)
     *
     * @author fdipzone
     * @DateTime 2023-07-01 23:14:19
     *
     * @param string $str 要转换的数据
     * @param string $in_charset 输入数据的字符集编码
     * @param string $out_charset 输出数据的字符集编码
     * @return string
     */
     public static function convert(string $str, string $in_charset, string $out_charset):string
    {
        // 参数验证
        if(!self::validCharset($str))
        {
            throw new \Exception('str is empty');
        }

        if(!self::validCharset($in_charset))
        {
            throw new \Exception('in charset type not supported');
        }

        if(!self::validCharset($out_charset))
        {
            throw new \Exception('out charset type not supported');
        }

        // 将数据先转为utf8编码，如输入数据已经是utf8则不需要转换
        $utf8_str = self::convertToUtf8($str, $in_charset);

        // 再将数据从utf8编码转为目标编码，如输出数据已经是utf8则不需要转换
        $converted_str = self::convertFromUtf8($utf8_str, $out_charset);

        return $converted_str;
    }

    /**
     * 判断字符集编码是否支持
     *
     * @author fdipzone
     * @DateTime 2023-07-01 23:07:03
     *
     * @param string $charset 字符集编码
     * @return boolean
     */
    private static function validCharset(string $charset):bool
    {
        switch($charset)
        {
            case self::ANSI:
            case self::UTF8:
            case self::UTF8BOM:
            case self::UTF16:
            case self::UTF16BE:
                return true;
        }

        return false;
    }

    /**
     * 将数据转换为utf8编码
     *
     * @author fdipzone
     * @DateTime 2023-07-01 23:19:22
     *
     * @param string $str 数据
     * @param string $charset 数据字符集编码
     * @return string
     */
    private static function convertToUtf8(string $str, string $charset):string
    {
        switch($charset)
        {
            case self::ANSI:
                $utf8_str = iconv('GBK', 'UTF-8//IGNORE', $str);
                break;

            case self::UTF8BOM:
                $utf8_str = substr($str, 3);
                break;

            case self::UTF16:
                $utf8_str = iconv('UTF-16le', 'UTF-8//IGNORE', substr($str, 2));
                break;

            case self::UTF16BE:
                $utf8_str = iconv('UTF-16be', 'UTF-8//IGNORE', substr($str, 2));
                break;

            default:
                $utf8_str = $str;
        }

        return $utf8_str;
    }

    /**
     * 将utf8编码的数据转换为指定编码
     *
     * @author fdipzone
     * @DateTime 2023-07-01 23:19:55
     *
     * @param string $utf8_str utf8编码的数据
     * @param string $charset 指定要转换的字符集编码
     * @return string
     */
    private static function convertFromUtf8(string $utf8_str, string $charset):string
    {
        switch($charset)
        {
            case self::ANSI:
                $converted_str = iconv('UTF-8', 'GBK//IGNORE', $utf8_str);
                break;

            case self::UTF8BOM:
                $converted_str = "\xef\xbb\xbf".$utf8_str;
                break;

            case self::UTF16:
                $converted_str = "\xff\xfe".iconv('UTF-8', 'UTF-16le//IGNORE', $utf8_str);
                break;

            case self::UTF16BE:
                $converted_str = "\xfe\xff".iconv('UTF-8', 'UTF-16be//IGNORE', $utf8_str);
                break;

            default:
                $converted_str = $utf8_str;
        }

        return $converted_str;
    }
}