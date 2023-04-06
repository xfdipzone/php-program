<?php
/**
 * php HTML实体编号与非ASCII字符串相互转换类
 *
 * @author fdipzone
 * @DateTime 2023-04-06 21:34:32
 *
 * Func:
 * public  encode 字符串转为HTML实体编号
 * public  decode HTML实体编号转为字符串
 * private _convertToHtmlEntities 转换为HTML实体编号处理
 */
class HtmlEntityConverter{

    /**
     * 编码
     *
     * @var string
     */
    private static $_encoding = 'UTF-8';

    /**
     * 字符串转为HTML实体编号
     *
     * @author fdipzone
     * @DateTime 2023-04-06 21:40:07
     *
     * @param string $str       字符串
     * @param string $encoding  编码
     * @return string
     */
    public static function encode(string $str, string $encoding='UTF-8'):string{
        self::$_encoding = $encoding;
        return preg_replace_callback('|[^\x00-\x7F]+|', array(__CLASS__, '_convertToHtmlEntities'), $str);
    }

    /**
     * HTML实体编号转为字符串
     *
     * @author fdipzone
     * @DateTime 2023-04-06 21:44:47
     *
     * @param string $str       HTML实体编号字符串
     * @param string $encoding  编码
     * @return string
     */
    public static function decode(string $str, string $encoding='UTF-8'):string{
        return html_entity_decode($str, ENT_NOQUOTES, $encoding);
    }

    /**
     * 转换为HTML实体编号处理
     *
     * @author fdipzone
     * @DateTime 2023-04-06 21:45:35
     *
     * @param mixed $data 待处理的数据
     * @return string
     */
    private static function _convertToHtmlEntities($data):string{
        if(is_array($data)){
            $chars = str_split(iconv(self::$_encoding, 'UCS-2BE', $data[0]), 2);
            $chars = array_map(array(__CLASS__, __FUNCTION__), $chars);
            return implode("", $chars);
        }else{
            $tmp = sprintf("%02s%02s;", dechex(ord($data[0])), dechex(ord($data[1])) );
            $hex = preg_replace('/[^0-9A-Fa-f]/', '', $tmp);
            $code = hexdec($hex);
            return sprintf("&#%s;", $code);
        }
    }

}
?>