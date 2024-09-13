<?php
namespace FileEncryptor;

/**
 * 基本文件加密器抽象类
 * 提供使用 openssl 加密与解密的加密器公用方法模版
 *
 * @author fdipzone
 * @DateTime 2024-09-13 17:42:06
 *
 */
abstract class AbstractBaseEncryptor implements \FileEncryptor\IFileEncryptor
{
    /**
     * 获取加密器名称
     * 抽象方法，由子类实现
     *
     * @author fdipzone
     * @DateTime 2024-09-13 18:15:25
     *
     * @return string
     */
    abstract public function name():string;

    /**
     * 获取加密算法
     * 抽象方法，由子类实现
     *
     * @author fdipzone
     * @DateTime 2024-09-13 18:15:36
     *
     * @return string
     */
    abstract public function cipherAlgo():string;

    /**
     * 获取加密初始化向量
     * 抽象方法，由子类实现
     *
     * @author fdipzone
     * @DateTime 2024-09-13 18:15:59
     *
     * @return string
     */
    abstract public function iv():string;

    /**
     * 密钥
     * 用于加密解密计算
     *
     * @var string
     */
    protected $encrypt_key;

    /**
     * 初始化
     * 设置密钥
     *
     * @author fdipzone
     * @DateTime 2024-09-10 09:49:40
     *
     * @param string $encrypt_key 密钥
     */
    final public function __construct(string $encrypt_key)
    {
        if(empty($encrypt_key))
        {
            throw new \Exception(sprintf('%s: encrypt key is empty', $this->name()));
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
    final public function encrypt(string $source_file, string $encrypt_file):bool
    {
        if(!file_exists($source_file))
        {
            throw new \Exception(sprintf('%s: source file not exists', $this->name()));
        }

        if(empty($encrypt_file))
        {
            throw new \Exception(sprintf('%s: encrypt file is empty', $this->name()));
        }

        try
        {
            $data = file_get_contents($source_file);
            $iv = $this->iv();
            $encrypt_data = openssl_encrypt($data, $this->cipherAlgo(), $this->encrypt_key, 0, $iv);

            // 将加密初始化向量加入加密文件中
            $encrypt_file_data = $encrypt_data . '::::' . base64_encode($iv);

            // 创建目标文件目录
            $dest_path = dirname($encrypt_file);
            if(!is_dir($dest_path))
            {
                mkdir($dest_path, 0777, true);
            }

            return (bool)(file_put_contents($encrypt_file, $encrypt_file_data));
        }
        catch(\Throwable $e)
        {
            return false;
        }
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
    final public function decrypt(string $encrypt_file, string $decrypt_file):bool
    {
        if(!file_exists($encrypt_file))
        {
            throw new \Exception(sprintf('%s: encrypt file not exists', $this->name()));
        }

        if(empty($decrypt_file))
        {
            throw new \Exception(sprintf('%s: decrypt file is empty', $this->name()));
        }

        try
        {
            $encrypt_file_data = file_get_contents($encrypt_file);

            // 从加密文件中获取初始化向量
            list($encrypt_data, $base64_iv) = explode('::::', $encrypt_file_data);
            $iv = base64_decode($base64_iv);

            $decrypt_data = openssl_decrypt($encrypt_data, $this->cipherAlgo(), $this->encrypt_key, 0, $iv);

            // 创建目标文件目录
            $dest_path = dirname($decrypt_file);
            if(!is_dir($dest_path))
            {
                mkdir($dest_path, 0777, true);
            }

            return (bool)(file_put_contents($decrypt_file, $decrypt_data));
        }
        catch(\Throwable $e)
        {
            return false;
        }
    }
}