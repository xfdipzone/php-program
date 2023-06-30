<?php
/**
 * 字符编码转换类
 * 支持ANSI、Unicode、Unicode big endian、UTF-8、UTF-8+Bom互相转换
 *
 * @author fdipzone
 * @DateTime 2023-06-29 23:55:15
 *
 */
class CharsetConvert
{
    /**
     * 输入数据编码
     *
     * @var string
     * @author fdipzone
     */
    private $in_charset = '';

    /**
     * 输出数据编码
     *
     * @var string
     */
    private $out_charset = '';

    /**
     * 初始化，传入输入数据编码与输出数据编码
     *
     * @author fdipzone
     * @DateTime 2023-06-30 23:23:15
     *
     * @param string $in_charset 输入数据编码
     * @param string $out_charset 输出数据编码
     */
    public function __construct(string $in_charset, string $out_charset)
    {
        $this->in_charset = $in_charset;
        $this->out_charset = $out_charset;
    }
}