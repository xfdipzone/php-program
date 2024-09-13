# php-file-encryptor

php 文件加密类

## 介绍

php 实现的文件加密解密类，可以对文件进行加密与解密操作，支持多种加密算法

---

## 功能

- 加密文件

  将文件按指定算法加密

- 解密文件

  按指定算法解密已经加密的文件

- 支持的加密算法

  - XOR 异或加密算法

  - AES AES-256-CBC 加密算法

  - DES DES 加密算法

---

## 类说明

**Factory** `FileEncryptor/Factory.php`

文件加密器工厂类，用于生成文件加密器实例

**IFileEncryptor** `FileEncryptor/IFileEncryptor.php`

文件加密器接口，定义文件加密器必须实现的方法

**Type** `FileEncryptor/Type.php`

定义支持的文件加密器类型

**XorEncryptor** `FileEncryptor/XorEncryptor.php`

XOR 异或算法文件加密器

**AbstractBaseEncryptor** `FileEncryptor/AbstractBaseEncryptor.php`

基于 openssl 加密解密算法的公用模版抽象类

**AesEncryptor** `FileEncryptor/AesEncryptor.php`

AES 算法文件加密器

**DesEncryptor** `FileEncryptor/DesEncryptor.php`

DES 算法文件加密器

---

## 演示

```php
$source_file = '/tmp/source_file.txt';
$encrypt_file = '/tmp/encrypt_file.txt';
$decrypt_file = '/tmp/decrypt_file.txt';

// 写入源文件数据
file_put_contents($source_file, 'test content');

// 密钥
$encrypt_key = '123456';

// xor 文件加密器
$xor_encryptor = \FileEncryptor\Factory::make(\FileEncryptor\Type::XOR, $encrypt_key);
$xor_encryptor->encrypt($source_file, $encrypt_file);
$xor_encryptor->decrypt($encrypt_file, $decrypt_file);
assert(file_get_contents($source_file)==file_get_contents($decrypt_file));

// aes 文件加密器
$aes_encryptor = \FileEncryptor\Factory::make(\FileEncryptor\Type::AES, $encrypt_key);
$aes_encryptor->encrypt($source_file, $encrypt_file);
$aes_encryptor->decrypt($encrypt_file, $decrypt_file);
assert(file_get_contents($source_file)==file_get_contents($decrypt_file));

// des 文件加密器
$des_encryptor = \FileEncryptor\Factory::make(\FileEncryptor\Type::DES, $encrypt_key);
$des_encryptor->encrypt($source_file, $encrypt_file);
$des_encryptor->decrypt($encrypt_file, $decrypt_file);
assert(file_get_contents($source_file)==file_get_contents($decrypt_file));
```

更多功能演示可参考单元测试代码 [FileEncryptor Unit Test](<https://github.com/xfdipzone/php-program/tree/master/tests/FileEncryptor>)

---

## XOR 文件加密性能优化

[C语言版本与PHP版本的XOR文件加密器性能对比](<https://github.com/xfdipzone/php-program/tree/master/php-file-encryptor/Xor-Performance.md>)
