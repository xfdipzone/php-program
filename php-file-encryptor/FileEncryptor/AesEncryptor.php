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
class AesEncryptor extends \FileEncryptor\AbstractBaseEncryptor implements \FileEncryptor\IFileEncryptor
{
    /**
     * 加密器名称
     *
     * @var string
     */
    private $name = 'aes encryptor';

    /**
     * 加密算法
     *
     * @var string
     */
    private $cipher_algo = 'AES-256-CBC';

    /**
     * 获取加密器名称
     *
     * @author terry
     * @DateTime 2024-09-13 17:52:37
     *
     * @return string
     */
    public function name():string
    {
        return $this->name;
    }

    /**
     * 获取加密算法
     *
     * @author terry
     * @DateTime 2024-09-13 17:51:10
     *
     * @return string
     */
    public function cipherAlgo():string
    {
        return $this->cipher_algo;
    }

    /**
     * 获取加密初始化向量
     *
     * @author terry
     * @DateTime 2024-09-13 17:54:18
     *
     * @return string
     */
    public function iv():string
    {
        $iv = openssl_random_pseudo_bytes(16);
        return $iv;
    }
}