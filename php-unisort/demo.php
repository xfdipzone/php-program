<?php
/**
 * php 文件内容去重及排序
 * Date:    2017-06-15
 * Author:  fdipzone
 * Ver:     1.0
 *
 * Func
 * fileUniSort 文件内容去重及排序
 * filter      过滤空行
 */

/**
 * 文件内容去重及排序
 * @param String $source    源文件
 * @param String $dest      目标文件
 * @param String $order     排序顺序
 * @param Int    $sort_flag 排序类型 SORT_NUMERIC/SORT_STRING
 */
function fileUniSort($source, $dest, $order='asc', $sort_flag=SORT_NUMERIC){

    // 读取文件内容
    $file_data = file_get_contents($source);

    // 文件内容按行分割为数组
    $file_data_arr = explode(PHP_EOL, $file_data);

    // 去除空行数据
    $file_data_arr = array_filter($file_data_arr, 'filter');

    // 去重
    $file_data_arr = array_flip($file_data_arr);
    $file_data_arr = array_flip($file_data_arr);

    // 排序
    if($order=='asc'){
        sort($file_data_arr, $sort_flag);
    }else{
        rsort($file_data_arr, $sort_flag);
    }

    // 数组合拼为文件内容
    $file_data = implode(PHP_EOL, $file_data_arr).PHP_EOL;

    // 写入文件
    file_put_contents($dest, $file_data, true);

}

// 过滤空行
function filter($data){
    if(!$data && $data!=='0'){
        return false;
    }
    return true;
}

// 设置可使用内存为256m，可根据数据量进行设置
ini_set('memory_limit', '256m');

$source = 'user_id.txt';
$dest = 'php_sort_user_id.txt';

// 写入1000000个数字，每行一个数字
$num = 1000000;
$tmp = '';

for($i=0; $i<$num; $i++){
    $tmp .= mt_rand(0,999999).PHP_EOL;
    if($i>0 && $i%1000==0 || $i==$num-1){
        file_put_contents($source, $tmp, FILE_APPEND);
        $tmp = '';
    }
}

// 执行去重及排序
fileUniSort($source, $dest);

?>
