<?php
/**
 * php 文件与16进制串转换器
 *
 * @author fdipzone
 * @DateTime 2023-03-21 20:03:12
 *
 */
class HexFileConverter{

    /**
     * 文件转为16进制串
     *
     * @author fdipzone
     * @DateTime 2023-03-21 20:04:59
     *
     * @param string $file 文件
     * @return string
     */
    public static function fileToHex(string $file):string{
        if(!file_exists($file)){
            throw new \Exception('file not exists');
        }

        $data = file_get_contents($file);
        return bin2hex($data);
    }

    /**
     * 16进制串转为文件
     *
     * @author fdipzone
     * @DateTime 2023-03-21 20:05:29
     *
     * @param string $hex_str 16进制串
     * @param string $file    生成的文件
     * @return boolean
     */
    public static function hexToFile(string $hex_str, string $file):bool{
        try{
            $data = pack('H*', $hex_str);
            file_put_contents($file, $data, true);
        }catch(\Throwable $e){
            throw new \Exception('hex str convert file fail');
        }
        return true;
    }

}