# php-css-updater

php CSS 更新类

## 介绍

php 实现的 CSS 文件更新类，用于更新 CSS 文件内的引用文件版本`（时间版本）`，避免访问 CDN 缓存的数据，强制使用最新的数据

例如：

```css
body {
    background-image: url('images/background.jpg');
}
```

更新后

```css
body {
    background-image: url('images/background.jpg?20240919101926');
}
```

---

## 功能

- 遍历指定目录中所有 CSS 文件

  可设置是否递归遍历子目录

- 更新 CSS 文件中引用文件的版本

  可设置要更新的引用文件后缀

---

## 类说明

**CssUpdater** `CssManager/CssUpdater.php`

CSS 文件更新器，用于遍历目录，更新 CSS 文件中引用文件版本

**Utils** `CssManager/Utils.php`

通用方法集合，包括检查文件后缀，遍历，创建目录，记录日志等

---

## 演示

```php
$css_tmpl_path = '/tmp/css_tmpl';
$css_path = '/tmp/css';
$replace_tags = ['jpg', 'png', 'gif'];

$log_file = '/tmp/update.log';

// 不遍历子目录
$css_updater = new \CssManager\CssUpdater($css_tmpl_path, $css_path, $replace_tags);
$success_num = $css_updater->update();
echo $success_num.PHP_EOL;

// 遍历子目录
$css_updater = new \CssManager\CssUpdater($css_tmpl_path, $css_path, $replace_tags, true);
$css_updater->setLogFile($log_file);
$success_num = $css_updater->update();
echo $success_num.PHP_EOL;
```

更多功能演示可参考单元测试代码 [CssManager Unit Test](<../tests/CssManager>)
