<?php
namespace FileEncryptor;

/**
 * 定义支持的文件加密器类型
 *
 * @author fdipzone
 * @DateTime 2024-09-08 21:56:16
 *
 */
class Type
{
    // XOR 算法
    const XOR = 'xor';

    // AES-256-CBC 算法
    const AES = 'aes';

    // 类型与实现类对应关系
    public static $map = [
        self::XOR => '\FileEncryptor\XorEncryptor',
        self::AES => '\FileEncryptor\AesEncryptor',
    ];
}