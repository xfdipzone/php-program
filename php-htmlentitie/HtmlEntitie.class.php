<?php
/**
 * HTML实体编号与非ASCII字符串相互转换类
 * Date:    2016-09-07
 * Author:  fdipzone
 * Version: 1.0
 *
 * Func:
 * public  encode 字符串转为HTML实体编号
 * public  decode HTML实体编号转为字符串
 * private _convertToHtmlEntities 转换为HTML实体编号处理
 */
class HtmlEntitie{ // class start

    public static $_encoding = 'UTF-8';

    /**
     * 字符串转为HTML实体编号
     * @param  String $str      字符串
     * @param  String $encoding 编码
     * @return String
     */
    public static function encode($str, $encoding='UTF-8'){
        self::$_encoding = $encoding;
        return preg_replace_callback('|[^\x00-\x7F]+|', array(__CLASS__, '_convertToHtmlEntities'), $str);
    }

    /**
     * HTML实体编号转为字符串
     * @param  String $str      HTML实体编号字符串
     * @param  String $encoding 编码
     * @return String
     */
    public static function decode($str, $encoding='UTF-8'){
        return html_entity_decode($str, null, $encoding);
    }

    /**
     * 转换为HTML实体编号处理
     * @param Mixed  $data 待处理的数据
     * @param String
     */
    private static function _convertToHtmlEntities($data){
        if(is_array($data)){
            $chars = str_split(iconv(self::$_encoding, 'UCS-2BE', $data[0]), 2);
            $chars = array_map(array(__CLASS__, __FUNCTION__), $chars);
            return implode("", $chars);
        }else{
            $code = hexdec(sprintf("%02s%02s;", dechex(ord($data {0})), dechex(ord($data {1})) ));
            return sprintf("&#%s;", $code);
        }
    }

} // class end
?>