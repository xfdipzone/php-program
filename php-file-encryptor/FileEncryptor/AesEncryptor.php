<?php
namespace FileEncryptor;

/**
 * 基于 AES-256-CBC 算法实现的文件加密器
 * 使用 openssl 加密与解密
 *
 * @author fdipzone
 * @DateTime 2024-09-10 09:47:41
 *
 */
class AesEncryptor implements \FileEncryptor\IFileEncryptor
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
     * @DateTime 2024-09-10 09:49:40
     *
     * @param string $encrypt_key 密钥
     */
    public function __construct(string $encrypt_key)
    {
        if(empty($encrypt_key))
        {
            throw new \Exception('aes encryptor: encrypt key is empty');
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
            throw new \Exception('aes encryptor: source file not exists');
        }

        if(empty($encrypt_file))
        {
            throw new \Exception('aes encryptor: encrypt file is empty');
        }

        try
        {
            $data = file_get_contents($source_file);
            $iv = openssl_random_pseudo_bytes(16);
            $encrypt_data = openssl_encrypt($data, 'AES-256-CBC', $this->encrypt_key, 0, $iv);

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
    public function decrypt(string $encrypt_file, string $decrypt_file):bool
    {
        if(!file_exists($encrypt_file))
        {
            throw new \Exception('aes encryptor: encrypt file not exists');
        }

        if(empty($decrypt_file))
        {
            throw new \Exception('aes encryptor: decrypt file is empty');
        }

        try
        {
            $encrypt_file_data = file_get_contents($encrypt_file);

            // 从加密文件中获取初始化向量
            list($encrypt_data, $base64_iv) = explode('::::', $encrypt_file_data);
            $iv = base64_decode($base64_iv);

            $decrypt_data = openssl_decrypt($encrypt_data, 'AES-256-CBC', $this->encrypt_key, 0, $iv);

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