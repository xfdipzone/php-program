# php-html-attrib-filter

php html标记属性过滤器

## 介绍

使用php实现对html标记中属性进行过滤

**功能包括：**

- 设置允许保留的属性

- 设置忽略的标记

- 设置特例标记属性

---

## 演示

```php
require('HtmlAttribFilter.php');

// html字符串
$str = '<div class="bd clear_fix" id="index_high_lite_ul"><ul class="list"><li><img src="http://su.bdimg.com/static/skin/img/logo_white.png" width="118" height="148"><div class="cover"><a class="text" href="http://www.csdn.net"><strong>yoga</strong><p>love</p></a><strong class="t g">want to know</strong><a href="/login.html" class="ppBtn"><strong class="text">YES</strong></a></div></li></ul></div>';

// 创建filter类对象
$filter = new HtmlAttribFilter();

// 允许id属性
$filter->setAllow(array('id'));

// 设置特例标记属性
$filter->setException(array(
    'a' => array('href'),   // a 标签允许有 href属性特例
    'ul' => array('class')  // ul 标签允许有 class属性特例
));

// img 标签忽略,不过滤任何属性
$filter->setIgnore(array('img'));

echo 'source str:'.PHP_EOL;
echo $str.PHP_EOL.PHP_EOL;

echo 'filter str:'.PHP_EOL;
echo $filter->strip($str).PHP_EOL;
```

过滤后输出：

```html
<div id="index_high_lite_ul"><ul class="list"><li><img src="http://su.bdimg.com/static/skin/img/logo_white.png" width="118" height="148"><div><a href="http://www.csdn.net"><strong>yoga</strong><p>love</p></a><strong>want to know</strong><a href="/login.html"><strong>yes</strong></a></div></li></ul></div>
```
