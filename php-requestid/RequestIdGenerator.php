<?php
/**
 * php 唯一RequestID生成器类
 *
 * @author fdipzone
 * @DateTime 2023-03-30 14:15:39
 *
 * Description:
 * PHP实现唯一RequestID生成类，使用session_create_id()与uniqid()方法实现，保证唯一性。
 *
 * Func:
 * public  generate 生成唯一请求id
 * private format   格式化请求id
 */
class RequestIdGenerator{

    /**
     * 生成唯一请求id
     *
     * @author fdipzone
     * @DateTime 2023-03-30 14:16:12
     *
     * @return string
     */
    public static function generate():string{

        // 使用session_create_id()方法创建前缀
        $prefix = session_create_id(date('YmdHis'));

        // 使用uniqid()方法创建唯一id
        $request_id = strtoupper(md5(uniqid($prefix, true)));

        // 格式化请求id
        return self::format($request_id);

    }

    /**
     * 格式化请求id
     *
     * @author fdipzone
     * @DateTime 2023-03-30 16:41:36
     *
     * @param string $request_id 请求id
     * @param string $format     格式（将长度为32的字符串拆分为多段字符串）
     * @return string
     */
    private static function format(string $request_id, string $format='8,4,4,4,12'):string{

        $tmp = array();
        $offset = 0;

        $cut = explode(',', $format);

        // 根据设定格式化
        if($cut){
            foreach($cut as $v){
                $tmp[] = substr($request_id, $offset, $v);
                $offset += $v;
            }
        }

        // 加入剩余部分
        if($offset<strlen($request_id)){
            $tmp[] = substr($request_id, $offset);
        }

        return implode('-', $tmp);

    }

}
?>