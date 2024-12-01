# php-validator

php验证类

## 介绍

php 实现的验证类，包括通用验证类（CommonValidator），语言验证类（LanguageValidator）与证件号码验证类（IDNumberValidator）

**通用验证类** 用于常用表单项的验证场景

**语言验证类** 用于语言文字相关的验证场景

**证件号码验证类** 用于各种证件号码的验证场景

---

## 功能

通用验证类支持的验证功能：

- 验证为空

- 验证长度（长度范围）

- 验证数字（浮点型，整型，带符号）

- 验证 Http Url

- 验证域名

- 验证 Email

- 验证日期（年份范围）

- 验证日期时间

- 验证版本

- 验证坐标经度

- 验证坐标纬度

- 验证文件后缀

语言验证类支持的验证功能：

- 英文

- 中文

- 泰文

- 越南文

证件号码验证类支持的验证功能：

- 验证中国身份证号码（18位）

- 验证中国车牌号码（包括新能源车牌）

---

## 演示

```php
// CommonValidator
var_dump(\Validator\CommonValidator::empty('0', false)); // false

var_dump(\Validator\CommonValidator::length('abc', 3, 5)); // true

var_dump(\Validator\CommonValidator::number(123.45, false, false)); // false

var_dump(\Validator\CommonValidator::httpUrl('https://www.fdipzone.com')); // true

var_dump(\Validator\CommonValidator::domain('www.fdipzone..com')); // false

var_dump(\Validator\CommonValidator::email('good@fdipzone.com')); // true

var_dump(\Validator\CommonValidator::date('1988-01-01', 1900, 2000)); // true

var_dump(\Validator\CommonValidator::datetime('2023-02-29 12:00:00')); // false

var_dump(\Validator\CommonValidator::version('1.0.0.1')); // true

var_dump(\Validator\CommonValidator::longitude(113.327782)); // true

var_dump(\Validator\CommonValidator::latitude(23.137202)); // true

var_dump(\Validator\CommonValidator::fileExtension('a.jpg', ['jpg', 'gif', 'png'])); // true

// LanguageValidator
var_dump(\Validator\LanguageValidator::isEnglish('hello')); // true

var_dump(\Validator\LanguageValidator::isChinese('你好')); // true

var_dump(\Validator\LanguageValidator::isThai('สวัสดี')); // true

var_dump(\Validator\LanguageValidator::isVietnamese('Xin chào')); // true

// IDNumberValidator
var_dump(\Validator\IDNumberValidator::idCard('441234567890123456')); // false

var_dump(\Validator\IDNumberValidator::licensePlateNumber('粤AF12345')); // true
```

更多功能演示可参考单元测试代码 [Validator Unit Test](<../tests/Validator>)
