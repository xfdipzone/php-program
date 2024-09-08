<?php
namespace FileEncryptor;

/**
 * 基于 XOR 算法实现的文件加密器
 * 算法原理：将文件每一个字节与密钥作位异或运算（XOR），解密则再执行一次异或运算
 *
 * @author fdipzone
 * @DateTime 2024-09-08 21:37:08
 *
 */
class XorEncryptor implements \FileEncryptor\IFileEncryptor
{
    /**
     * 密钥
     * 用于加密解密计算
     *
     * @var string
     */
    private $encrypt_key;

    /**
     * 初始化
     * 设置密钥
     *
     * @author fdipzone
     * @DateTime 2024-09-08 11:40:22
     *
     * @param string $key
     */
    public function __construct(string $encrypt_key)
    {
        if(empty($encrypt_key))
        {
            throw new \Exception('xor encryptor: encrypt key is empty');
        }

        $this->encrypt_key = $encrypt_key;
    }

    /**
     * 加密文件
     *
     * @author fdipzone
     * @DateTime 2024-09-08 11:36:56
     *
     * @param string $source_file 源文件路径
     * @param string $encrypt_file 加密后文件路径
     * @return boolean
     */
    public function encrypt(string $source_file, string $encrypt_file):bool
    {
        if(!file_exists($source_file))
        {
            throw new \Exception('xor encryptor: source file not exists');
        }

        if(empty($encrypt_file))
        {
            throw new \Exception('xor encryptor: encrypt file is empty');
        }

        return $this->xorEncrypt($source_file, $encrypt_file);
    }

    /**
     * 解密文件
     *
     * @author fdipzone
     * @DateTime 2024-09-08 11:37:06
     *
     * @param string $encrypt_file 加密文件路径
     * @param string $decrypt_file 解密后文件路径
     * @return boolean
     */
    public function decrypt(string $encrypt_file, string $decrypt_file):bool
    {
        if(!file_exists($encrypt_file))
        {
            throw new \Exception('xor encryptor: encrypt file not exists');
        }

        if(empty($decrypt_file))
        {
            throw new \Exception('xor encryptor: decrypt file is empty');
        }

        return $this->xorEncrypt($encrypt_file, $decrypt_file);
    }

    /**
     * XOR 加解密算法
     * 这里不加入参数检查，因为此方法为私有方法，在公用方法调用的时候已经做了参数检查
     *
     * @author fdipzone
     * @DateTime 2024-09-08 11:55:04
     *
     * @param string $source_file 源文件
     * @param string $dest_file 目标文件
     * @return boolean
     */
    private function xorEncrypt(string $source_file, string $dest_file):bool
    {
        try
        {
            $content = '';
            $key_len = strlen($this->encrypt_key);
            $index = 0;

            $fp = fopen($source_file, 'rb');

            // 循环读取文件每一位与密钥作位异或运算
            while(!feof($fp))
            {
                $tmp = fread($fp, 1);
                $content .= $tmp ^ substr($this->encrypt_key, $index % $key_len, 1);
                $index++;
            }

            fclose($fp);

            // 创建目标文件目录
            $dest_path = dirname($dest_file);
            if(!is_dir($dest_path))
            {
                mkdir($dest_path, 0777, true);
            }

            return (bool)(file_put_contents($dest_file, $content));
        }
        catch(\Throwable $e)
        {
            return false;
        }
    }
}