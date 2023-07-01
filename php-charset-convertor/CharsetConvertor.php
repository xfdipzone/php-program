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
     * 输入数据的字符集编码
     *
     * @var string
     * @author fdipzone
     */
    private $in_charset = '';

    /**
     * 输出数据的字符集编码
     *
     * @var string
     */
    private $out_charset = '';

    /**
     * 初始化，传入输入数据的字符集编码与输出数据的字符集编码
     *
     * @author fdipzone
     * @DateTime 2023-06-30 23:23:15
     *
     * @param string $in_charset 输入数据的字符集编码
     * @param string $out_charset 输出数据的字符集编码
     */
    public function __construct(string $in_charset, string $out_charset)
    {
        if(!$this->validCharset($in_charset))
        {
            throw new \Exception('in charset type not supported');
        }

        if(!$this->validCharset($out_charset))
        {
            throw new \Exception('out charset type not supported');
        }

        $this->in_charset = $in_charset;
        $this->out_charset = $out_charset;
    }

    /**
     * 执行转换
     *
     * @author fdipzone
     * @DateTime 2023-07-01 23:14:19
     *
     * @param string $str 要转换的数据
     * @return string
     */
    public function convert(string $str):string
    {
        // 将数据先转为utf8编码
        $utf8_str = $this->convertToUtf8($str, $this->in_charset);

        // 再将数据从utf8编码转为目标编码
        $converted_str = $this->convertFromUtf8($utf8_str, $this->out_charset);

        return $converted_str;
    }

    /**
     * 判断字符集编码
     *
     * @author fdipzone
     * @DateTime 2023-07-01 23:07:03
     *
     * @param string $charset
     * @return boolean
     */
    private function validCharset(string $charset):bool
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
    private function convertToUtf8(string $str, string $charset):string
    {
        return '';
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
    private function convertFromUtf8(string $utf8_str, string $charset):string
    {
        return '';
    }
}