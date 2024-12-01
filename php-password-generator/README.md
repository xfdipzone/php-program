# php-password-generator

php 密码生成类

## 介绍

php 实现的随机密码生成类，可以设置密码的组成规则，例如包含 `大写字母`，`小写字母`，`数字`，`特殊字符` 等

---

## 功能

自定密码组成规则，根据密码组成规则生成密码

---

## 类说明

**Generator** `PasswordGenerator/Generator.php`

密码生成器，根据规则生成密码

**Rule** `PasswordGenerator/Rule.php`

密码生成规则类，定义密码组成规则

---

## 演示

```php
$length = 8;
$rule = new \PasswordGenerator\Rule($length);
$rule->setHasUppercase(true);
$rule->setHasLowercase(true);
$rule->setHasNumber(true);
$rule->setHasSpecialCharacter(true);
$rule->setSpecialCharacters('!@#$');

$passwords = \PasswordGenerator\Generator::generate($rule, 10);
print_r($passwords);
```

更多功能演示可参考单元测试代码 [PasswordGenerator Unit Test](<../tests/PasswordGenerator>)
