# Demo 流程

## 1.目录

程序目录需要设置为使用 `http://localhost/recaptcha/` 路径访问

例如：www 是 localhost 的根目录，那么程序目录就是 www/recaptcha

将 `php-csrf` 目录复制到 recaptcha 目录中

---

## 2.安装 composer 依赖

```shell
composer install
```

---

## 3.注册 google recaptcha

注册地址：[https://www.google.com/recaptcha/admin/create](<https://www.google.com/recaptcha/admin/create>)

请分别注册 v2, v3 版本各一个，域名设置为 `localhost`

![google reCaptcha v2 config](<./google_recaptcha_v2.jpg>)

![google reCaptcha v2 config](<./google_recaptcha_v3.jpg>)

获取客户端 `Site Key` 与 服务端 `Secret` 填入 `config.php` 配置项

---

## 4.运行 google recaptcha v2 测试

[http://localhost/recaptcha/demo_v2.php](<http://localhost/recaptcha/demo_v2.php>)

---

## 5.运行 google recaptcha v3 测试

[http://localhost/recaptcha/demo_v3.php](<http://localhost/recaptcha/demo_v3.php>)

---

## 6.运行混合测试

混合测试流程：

v3 自动检测，不需要人手执行操作，因此可以先用 v3 来检测

如果 v3 检测失败，则使用 v2 人手检测

在生产环境使用这个流程对用户体验更好

[http://localhost/recaptcha/demo_flow.php](<http://localhost/recaptcha/demo_flow.php>)
