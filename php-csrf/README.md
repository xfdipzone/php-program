# php-csrf

## 介绍

php 实现的 CSRF(Cross-Site Request Forgery) 组件类，实现 `CSRF Token` 生成与验证功能，支持使用多种组件实现

提升系统接口调用安全性，避免接口被恶意请求，拦截机器人请求，维护系统稳定

**CSRF** 跨站请求伪造（Cross-Site Request Forgery，简称 CSRF）是一种网络攻击方式

攻击者通过诱使用户在已认证的情况下向受信任的网站发送恶意请求，从而执行未授权的操作

---

## 功能

提供三个组件，`Google Recaptcha V2`, `Google Recaptcha V3`, `InternalCsrf`

主要功能如下：

- 创建 CSRF TOKEN

- 验证 CSRF TOKEN

`Google Recaptcha V2` 与 `Google Recaptcha V3` 依赖 Google Recaptcha Lib

使用 Google Recaptcha 提供的 Javascript Lib 生成 CSRF Token，服务端只实现验证 CSRF Token 功能

`InternalCsrf` 是自主开发的 CSRF 组件，提供 CSRF Token 的生成与验证功能

---

## 类关系图

![CSRF 组件类关系图](<./class_diagram.svg>)

<details>
<summary>点击查看 PlantUML 代码</summary>
<pre>
<code>
```plantuml
@startuml component-diagram
!includeurl https://raw.githubusercontent.com/RicardoNiepel/C4-PlantUML/release/1-0/C4_Component.puml
title "CSRF 组件类关系图"
Component(IConfig, "IConfig", "CSRF 组件配置接口")
Component(GoogleRecaptchaV2Config, "GoogleRecaptchaV2Config", "Google Recaptcha V2 CSRF 组件配置类")
Component(GoogleRecaptchaV3Config, "GoogleRecaptchaV3Config", "Google Recaptcha V3 CSRF 组件配置类")
Component(InternalCsrfConfig, "InternalCsrfConfig", "内部 CSRF 组件配置类")
Component(Type, "Type", " CSRF 组件类型")
Component(VerifyResponse, "VerifyResponse", "CSRF 组件验证返回结构")
Component(GoogleRecaptchaV2, "GoogleRecaptchaV2", "Google Recaptcha V2 CSRF 组件")
Component(GoogleRecaptchaV3, "GoogleRecaptchaV3", "Google Recaptcha V3 CSRF 组件")
Component(InternalCsrf, "InternalCsrf", "内部 CSRF 组件")
Component(CryptoUtils, "CryptoUtils", "加密解密类")
Component(ICsrf, "ICsrf", "CSRF 组件接口")
Component(Factory, "Factory", "CSRF 组件工厂类")
Rel_Back(IConfig, GoogleRecaptchaV2Config, "implements")
Rel_Back(IConfig, GoogleRecaptchaV3Config, "implements")
Rel_Back(IConfig, InternalCsrfConfig, "implements")
Rel_Back(ICsrf, GoogleRecaptchaV2, "implements")
Rel_Back(ICsrf, GoogleRecaptchaV3, "implements")
Rel_Back(ICsrf, InternalCsrf, "implements")
Rel(InternalCsrf, CryptoUtils, "depend on")
Rel(Factory, IConfig, "depend on")
Rel(Factory, ICsrf, "depend on")
Rel(Factory, Type, "depend on")
Rel(Factory, VerifyResponse, "depend on")
@enduml
```
</code>
</pre>
</details>

---

## 类说明

**IConfig** `Csrf/Config/IConfig.php`

定义 CSRF 组件配置接口

**GoogleRecaptchaV2Config** `Csrf/Config/GoogleRecaptchaV2Config.php`

Google Recaptcha V2 CSRF 组件配置

**GoogleRecaptchaV3Config** `Csrf/Config/GoogleRecaptchaV3Config.php`

Google Recaptcha V3 CSRF组件配置

**InternalCsrfConfig** `Csrf/Config/InternalCsrfConfig.php`

内部 Csrf 组件配置

**CryptoUtils** `Csrf/CryptoUtils.php`

字符串加密解密类

**ICsrf** `Csrf/ICsrf.php`

定义 CSRF 组件接口，强制组件实现 `generate` (创建token)，`verify` (验证token) 方法

**Type** `Csrf/Type.php`

定义 CSRF 组件类型

**Factory** `Csrf/Factory.php`

CSRF 组件工厂类，根据组件类型，创建组件对象

**GoogleRecaptchaV2** `Csrf/GoogleRecaptchaV2.php`

基于 Google Recaptcha V2 实现CSRF组件（参考相关文档）

**GoogleRecaptchaV3** `Csrf/GoogleRecaptchaV3.php`

基于 Google Recaptcha V3 实现CSRF组件（参考相关文档）

**InternalCsrf** `Csrf/InternalCsrf.php`

内部实现的 CSRF 组件，没有第三方依赖

**VerifyResponse** `Csrf/VerifyResponse.php`

定义 CSRF 组件验证返回结构

---

## Google Recaptcha 相关文档

**Google Recaptcha Composer Lib:** [https://github.com/google/recaptcha](https://github.com/google/recaptcha)

```json
"require": {
    "google/recaptcha": "^1.2"
}
```

**Google Recaptcha 文档:** [https://developers.google.com/recaptcha/intro](https://developers.google.com/recaptcha/intro)

---

## 演示

```php
$secret = 'abc123';

$type = \Csrf\Type::INTERNAL_CSRF;
$config = new \Csrf\Config\InternalCsrfConfig($secret);
$csrf = \Csrf\Factory::make($type, $config);

$action = 'login';
$remote_ip = '192.168.1.1';
$token = $csrf->generate($action);

$response = $csrf->verify($token, $action, $remote_ip);
var_dump($response);
```

更多功能演示可参考单元测试代码 [Csrf Unit Test](<../tests/Csrf>)
