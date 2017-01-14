<?php
/**
 * php 文件与16进制相互转换
 * Date:    2017-01-14
 * Author:  fdipzone
 * Ver:     1.0
 *
 * Func
 * fileToHex 文件转16进制
 * hexToFile 16进制转文件
 */

/**
 * 将文件内容转为16进制输出
 * @param  String $file 文件路径
 * @return String
 */
function fileToHex($file){
    if(file_exists($file)){
        $data = file_get_contents($file);
        return bin2hex($data);
    }
    return '';
}

/**
 * 将16进制内容转为文件保存
 * @param String $hexstr 16进制内容
 * @param String $file   保存的文件路径
 */
function hexToFile($hexstr, $file){
    if($hexstr){
        $data = pack('H*', $hexstr);
        file_put_contents($file, $data, true);
    }
}

// 演示
$file = 'test.doc';

// 文件转16进制
$hexstr = fileToHex($file);
echo '文件转16进制<br>';
echo $hexstr.'<br><br>';

// 16进制转文件
$newfile = 'new.doc';
hexToFile($hexstr, $newfile);

echo '16进制转文件<br>';
var_dump(file_exists($newfile));

?>