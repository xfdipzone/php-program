<?php
/**
 * php 高亮输出数据类
 *
 * Description:
 * 支持在cli模式下输出数据，可以设置输出数据的文字颜色，背景颜色，粗体，下划线
 *
 * Func:
 * output 按设置输出数据
 *
 * @author fdipzone
 * @DateTime 2023-04-07 14:32:37
 *
 */
class CliHighLight{

    // 黑色
    const BLACK = 'black';

    // 红色
    const RED = 'red';

    // 绿色
    const GREEN = 'green';

    // 黄色
    const YELLOW = 'yellow';

    // 蓝色
    const BLUE = 'blue';

    // 紫色
    const PURPLE = 'purple';

    // 青色
    const CYAN = 'cyan';

    // 灰色
    const GREY = 'grey';

    /**
     * 颜色转换对照
     *
     * @var array
     */
    private static $color_map = array(
        self::BLACK => '30',
        self::RED => '31',
        self::GREEN => '32',
        self::YELLOW => '33',
        self::BLUE => '34',
        self::PURPLE => '35',
        self::CYAN => '36',
        self::GREY => '37'
    );

    /**
     * 背景颜色转换对照
     *
     * @var array
     */
    private static $bg_color_map = array(
        self::BLACK => '40',
        self::RED => '41',
        self::GREEN => '42',
        self::YELLOW => '43',
        self::BLUE => '44',
        self::PURPLE => '45',
        self::CYAN => '46',
        self::GREY => '47'
    );

    /**
     * 按设置输出数据
     * 判断如果不是cli模式，则按原始数据输出
     *
     * @author fdipzone
     * @DateTime 2023-04-07 14:44:09
     *
     * @param string $output        输出的数据内容
     * @param string $color         文字颜色
     * @param string $bg_color      背景颜色
     * @param boolean $bold         粗体 true/false
     * @param boolean $underline    下划线 true/false
     * @return string
     */
    public static function output(string $output, string $color, string $bg_color='', bool $bold=false, bool $underline=false):string{

        // 非cli模式，直接返回原始数据
        if(php_sapi_name()!='cli'){
            return $output;
        }

        // 获取color code
        $color_code = isset(self::$color_map[$color])? self::$color_map[$color] : '';

        // 获取bg color code
        $bg_color_code = isset(self::$bg_color_map[$bg_color])? self::$bg_color_map[$bg_color].';' : '';

        // 粗体
        $bold_code = $bold? '1;' : '';

        // 下划线
        $underline_code = $underline? '4;' : '';

        // 设置文字颜色与背景颜色
        if($color_code && $bg_color_code){
            $output = chr(27).'['. $underline_code . $bold_code . $bg_color_code . $color_code. 'm'.$output.chr(27).'[0m';

        // 只设置文字颜色，不设置背景颜色
        }elseif($color_code){
            $output = chr(27).'['. $underline_code . $bold_code . $color_code. 'm'.$output.chr(27).'[0m';
        }

        return $output;

    }

}