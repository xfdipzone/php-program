<?php
namespace FileEncryptor;
/**
 * 文件加密器接口
 * 定制文件加密器必须实现的方法
 *
 * @author fdipzone
 * @DateTime 2024-09-07 23:50:25
 *
 */
interface IFileEncryptor
{
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
    public function encrypt(string $source_file, string $encrypt_file):bool;

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
    public function decrypt(string $encrypt_file, string $decrypt_file):bool;
}