# php-captcha

php Captcha验证码类

## 介绍

使用php开发的 **Captcha** 验证码类，支持 `Session` 与 `Redis` 两种存储方式，用于存储验证码。

Captcha 是 "Completely Automated Public Turing test to tell Computers and Humans Apart" 缩写。

一种区分用户是 `计算机` 还是 `人` 的公共全自动程序。

通过验证码向请求的发起方提出问题，能正确回答的即是人类，反之则为机器。

验证码图片效果图：

![验证码图片效果图](https://github.com/xfdipzone/php-program/blob/master/php-captcha/captcha.png)

---

## 功能

主要功能如下：

- 根据配置生成验证码图片

  - 设置字体尺寸

  - 设置字体

  - 设置干扰点数量

  - 设置干扰线数量

- 存储验证码

  - 使用 `Session` 存储验证码

  - 使用 `Redis` 存储验证码

  - 设置验证码过期时间

- 验证

  - 验证用户输入的验证码是否匹配

  - 验证通过后，删除存储的验证码

---

## 演示

创建验证码图片

```php
require 'autoload.php';

// session storage
session_start();

$session_config = array(
    'expire' => 60
);
$session_storage_config = new \Captcha\Storage\SessionStorageConfig($session_config);
$session_storage = \Captcha\Storage\Factory::make(\Captcha\Storage\Type::SESSION, $session_storage_config);

$key = 'register:'.session_id();

$captcha_config = new \Captcha\Config($key, $session_storage);
$captcha_config->setFontSize(24);
$captcha_config->setPointNum(150);
$captcha_config->setLineNum(15);

// 输出验证码图片
\Captcha\Captcha::create($key, 6, $captcha_config);
```

验证

```php
require 'autoload.php';

// session storage
session_start();

$session_config = array(
    'expire' => 60
);
$session_storage_config = new \Captcha\Storage\SessionStorageConfig($session_config);
$session_storage = \Captcha\Storage\Factory::make(\Captcha\Storage\Type::SESSION, $session_storage_config);

$key = 'register:'.session_id();

// 获取用户输入的验证码
$validate_code = isset($_GET['validate_code'])? $_GET['validate_code'] : '';

// 执行验证
$ret = \Captcha\Captcha::validate($key, $validate_code, $session_storage);

var_dump($ret);
```
