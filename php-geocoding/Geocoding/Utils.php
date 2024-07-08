<?php
namespace Geocoding;

/**
 * 通用方法集合
 *
 * @author fdipzone
 * @DateTime 2024-07-04 22:06:40
 *
 */
class Utils
{
    /**
     * 发起请求
     *
     * @author fdipzone
     * @DateTime 2024-07-04 22:18:21
     *
     * @param string $url 访问的地址
     * @param array $param 请求参数
     * @param int $timeout 超时时间
     * @return array
     */
    public static function HttpRequest(string $url, array $param=[], int $timeout=5):array
    {
        $ch = curl_init();

        if(substr($url, 0, 5)=='https')
        {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);  // 从证书中检查SSL加密算法是否存在
        }

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($param));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);

        $response = curl_exec($ch);
        $error = curl_errno($ch);
        $err_msg = curl_error($ch);

        curl_close($ch);

        $ret = array(
            'error' => $error,
            'err_msg' => $err_msg,
            'response' => $response,
        );

        return $ret;
    }
}