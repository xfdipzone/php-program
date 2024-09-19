# XOR 文件加密性能优化

使用 **C** 实现 XOR 文件加密器

[XorEncryptor.c](<https://github.com/xfdipzone/php-program/tree/master/php-file-encryptor/XorEncryptor.c>)

## 1. 编译文件

```shell
gcc -o XorEncryptor XorEncryptor.c
```

## 2. 生成的执行文件需要加上可执行权限

```shell
chmod a+x XorEncryptor
```

## 3. 对一张容量为 `5MB` 的图片文件进行加解密操作

执行加密

```shell
./XorEncryptor /tmp/source.gif /tmp/encrypt.gif '@#$%^&*()_asdfDFG-HJKa_ds-kl_fj'
```

用时：0.39s user 0.01s system 97% cpu 0.407 total

执行解密

```shell
./XorEncryptor /tmp/encrypt.gif /tmp/decrypt.gif '@#$%^&*()_asdfDFG-HJKa_ds-kl_fj'
```

用时：0.39s user 0.01s system 98% cpu 0.409 total

## 4. 使用 php XOR 加密器测试

执行加密

```php
$source_file = '/tmp/source.gif';
$encrypt_file = '/tmp/encrypt.gif';

// 密钥
$encrypt_key = '@#$%^&*()_asdfDFG-HJKa_ds-kl_fj';

// xor 文件加密器
$xor_encryptor = \FileEncryptor\Factory::make(\FileEncryptor\Type::XOR, $encrypt_key);
$xor_encryptor->encrypt($source_file, $encrypt_file);
```

用时：2.24s user 0.03s system 99% cpu 2.287 total

执行解密

```php
$encrypt_file = '/tmp/encrypt.gif';
$decrypt_file = '/tmp/decrypt.gif';

// 密钥
$encrypt_key = '@#$%^&*()_asdfDFG-HJKa_ds-kl_fj';

// xor 文件加密器
$xor_encryptor = \FileEncryptor\Factory::make(\FileEncryptor\Type::XOR, $encrypt_key);
$xor_encryptor->decrypt($encrypt_file, $decrypt_file);
```

用时：2.23s user 0.03s system 99% cpu 2.269 total

## 总结

经过测试，C 语言版本用时 `0.407s`，PHP 语言版本用时 `2.287s`

C 语言实现的 XOR 文件加密器性能是 PHP 语言实现的 `5.62` 倍
