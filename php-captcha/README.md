# php-captcha

php Captcha验证码类

## 介绍

使用php开发的 **Captcha** 验证码类，支持 `Session` 与 `Redis` 两种存储方式，用于存储验证码。

Captcha 是 "Completely Automated Public Turing test to tell Computers and Humans Apart" 缩写。

一种区分用户是 `计算机` 还是 `人` 的公共全自动程序。

通过验证码向请求的发起方提出问题，能正确回答的即是人类，反之则为机器。

**文本型验证码图片效果图：**

![文本型验证码图片效果图](https://github.com/xfdipzone/php-program/blob/master/php-captcha/text_captcha.png)

**点击型验证码图片效果图：**

![点击型验证码图片效果图](https://github.com/xfdipzone/php-program/blob/master/php-captcha/click_captcha.png)

---

## 文本型验证码

### 文本型验证码功能

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

### 文本型验证码演示

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

$captcha_config = new \Captcha\TextCaptchaConfig($key, $session_storage);
$captcha_config->setFontSize(24);
$captcha_config->setPointNum(150);
$captcha_config->setLineNum(15);

// 输出验证码图片
\Captcha\TextCaptcha::create($key, 6, $captcha_config);
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
$ret = \Captcha\TextCaptcha::validate($key, $validate_code, $session_storage);

var_dump($ret);
```

---

## 点击型验证码

### 点击型验证码功能

主要功能如下：

- 根据配置生成验证码图片

  - 设置图片的尺寸

  - 设置混淆的图形数量

  - 设置图形的尺寸

- 存储验证码

  - 使用 `Session` 存储验证码

  - 使用 `Redis` 存储验证码

  - 设置验证码过期时间

- 验证

  - 验证用户提交的图片定位是否匹配

  - 验证通过后，删除存储的验证码

### 点击型验证码演示

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

$captcha_config = new \Captcha\ClickCaptchaConfig($key, $session_storage);
$captcha_config->setWidth(250);
$captcha_config->setHeight(150);
$captcha_config->setGraphNum(5);
$captcha_config->setGraphSize(45);

// 输出验证码图片
\Captcha\ClickCaptcha::create($key, $captcha_config);
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

// 获取用户点击的图片定位
$validate_code = isset($_GET['validate_code'])? $_GET['validate_code'] : '';

// 执行验证
$ret = \Captcha\ClickCaptcha::validate($key, $validate_code, $session_storage);

var_dump($ret);
```
