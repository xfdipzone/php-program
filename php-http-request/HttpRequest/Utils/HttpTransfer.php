<?php
namespace HttpRequest\Utils;

/**
 * http transfer类
 * 获取http返回数据的http transfer encode类型
 * 根据http transfer encode类型进行解密处理
 *
 * @author fdipzone
 * @DateTime 2023-06-17 18:01:11
 *
 */
class HttpTransfer
{
    const CHUNKED = 'chunked';

    /**
     * 获取http transfer加密类型
     *
     * @author fdipzone
     * @DateTime 2023-06-17 21:15:05
     *
     * @param string $http_response http返回数据
     * @return string
     */
    public static function type(string $http_response):string
    {
        // Transfer-Encoding: chunked
        if(strpos($http_response, 'Transfer-Encoding: chunked')!==false)
        {
            $http_transfer_type = self::CHUNKED;
        }
        else
        {
            $http_transfer_type = '';
        }

        return $http_transfer_type;
    }

    /**
     * 根据http transfer encode类型对http body进行解密
     *
     * @author fdipzone
     * @DateTime 2023-06-17 21:02:50
     *
     * @param string $http_body http body
     * @param string $http_transfer_type 加密类型
     * @return string
     */
    public static function decode(string $http_body, string $http_transfer_type):string
    {
        // Transfer-Encoding: chunked
        if($http_transfer_type==self::CHUNKED)
        {
            $http_body = self::httpChunkedDecode($http_body);
        }

        return $http_body;
    }

    /**
     * 执行http transfer chunked 类型的decode
     *
     * @author fdipzone
     * @DateTime 2023-06-17 21:26:55
     *
     * @param string $chunk chunked加密的字符串
     * @return string
     */
    private static function httpChunkedDecode(string $chunk):string
    {
        $pos = 0;
        $len = strlen($chunk);
        $de_chunk = null;

        while(($pos < $len) && ($chunkLenHex = substr($chunk,$pos, ($newlineAt = strpos($chunk,"\n",$pos+1))-$pos)))
        {
            if(!self::isHex($chunkLenHex))
            {
                return $chunk;
            }

            $pos = $newlineAt + 1;
            $chunkLen = hexdec(rtrim($chunkLenHex,"\r\n"));
            $de_chunk .= substr($chunk, $pos, $chunkLen);
            $pos = strpos($chunk, "\n", $pos + $chunkLen) + 1;
        }
        return $de_chunk;
    }

    /**
     * 判断是否16进制字符串
     *
     * @author fdipzone
     * @DateTime 2023-06-17 21:31:00
     *
     * @param string $hex 字符串
     * @return boolean
     */
    private static function isHex(string $hex):bool
    {
        $hex = strtolower(trim(ltrim($hex, "0")));
        if(empty($hex))
        {
            $hex = 0;
        }
        $dec = hexdec($hex);
        return ($hex == dechex($dec));
    }
}