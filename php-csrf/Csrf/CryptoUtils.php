<?php
namespace Csrf;

/**
 * 字符串加密解密类
 * 用于 csrf token 加密与解密
 * 使用 AES-256-CBC 算法
 *
 * @author fdipzone
 * @DateTime 2025-01-04 16:01:29
 *
 */
class CryptoUtils
{
    /**
     * 加密字符串
     *
     * @author fdipzone
     * @DateTime 2025-01-04 16:05:21
     *
     * @param string $source_string 源字符串
     * @param string $secret 密钥
     * @return string
     */
    public static function encrypt(string $source_string, string $secret):string
    {
        if(empty($source_string))
        {
            throw new \Csrf\Exception\CryptoException('source string is empty');
        }

        if(empty($secret))
        {
            throw new \Csrf\Exception\CryptoException('secret is empty');
        }

        $iv = openssl_random_pseudo_bytes(16);
        $encrypt_data = openssl_encrypt($source_string, 'AES-256-CBC', $secret, 0, $iv);

        // 将加密初始化向量加入加密字符串中
        $encrypt_string = $encrypt_data . '::::' . base64_encode($iv);
        return $encrypt_string;
    }

    /**
     * 解密字符串
     *
     * @author fdipzone
     * @DateTime 2025-01-04 16:05:46
     *
     * @param string $encrypt_string 加密的字符串
     * @param string $secret 密钥
     * @return string
     */
    public static function decrypt(string $encrypt_string, string $secret):string
    {
        if(empty($encrypt_string))
        {
            throw new \Csrf\Exception\CryptoException('encrypt string is empty');
        }

        if(empty($secret))
        {
            throw new \Csrf\Exception\CryptoException('secret is empty');
        }

        // 从加密文件中获取初始化向量
        list($encrypt_data, $base64_iv) = explode('::::', $encrypt_string);
        $iv = base64_decode($base64_iv);
        $decrypt_string = openssl_decrypt($encrypt_data, 'AES-256-CBC', $secret, 0, $iv);

        return $decrypt_string;
    }
}