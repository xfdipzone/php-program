<?php
namespace FileEncryptor;

/**
 * 文件加密器工厂类
 * 用于创建文件加密器实例
 *
 * @author fdipzone
 * @DateTime 2024-09-08 22:00:05
 *
 */
class Factory
{
    /**
     * 根据类型创建文件加密器实例
     *
     * @author fdipzone
     * @DateTime 2024-09-08 22:31:18
     *
     * @param string $type 文件加密器类型，在 \FileEncryptor\Type 中定义
     * @param string $encrypt_key 密钥
     * @return \FileEncryptor\IFileEncryptor
     */
    public static function make(string $type, string $encrypt_key):\FileEncryptor\IFileEncryptor
    {
        try
        {
            $class = self::getEncryptorClass($type);
            return new $class($encrypt_key);
        }
        catch(\Throwable $e)
        {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * 根据类型获取文件加密器类
     *
     * @author fdipzone
     * @DateTime 2024-09-08 22:30:45
     *
     * @param string $type 文件加密器类型，在 \FileEncryptor\Type 中定义
     * @return string
     */
    final public static function getEncryptorClass(string $type):string
    {
        if(isset(\FileEncryptor\Type::$map[$type]))
        {
            return \FileEncryptor\Type::$map[$type];
        }

        throw new \Exception(sprintf('file encryptor factory: type %s not exists', $type));
    }
}