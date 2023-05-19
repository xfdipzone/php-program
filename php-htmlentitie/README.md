# php-htmlentitie

php 实现Html实体编号与非ASCII字符串相互转换类

## 1. 介绍

HTML实体符号被用作实现保留字符（reserved characters）或者表达键盘无法输入的一些常用字符。

在大多数浏览器中默认的字符集为ISO-8859-1。HTML实体符号我们在网页设计中经常用到。

此类实现HTML实体编号与非ASCII字符串相互转换。

---

## 2. 调用

### encode

实现字符串转为HTML实体编号

### decode

实现HTML实体编号转为字符串

---

## 3. 例子

字符串转为HTML实体编号

```PHP
$str = '<p>破晓领域</p>';
echo HtmlEntityConverter::encode($str);
```

输出:

```txt
<p>&#30772;&#26195;&#39046;&#22495;</p>
```

HTML实体编号转为字符串

```PHP
$str = '<p>&#30772;&#26195;&#39046;&#22495;</p>';
echo HtmlEntityConverter::decode($str);
```

输出：

```txt
<p>破晓领域</p>
```

两种都可以在浏览器正常显示，如下图：

![效果图](https://github.com/xfdipzone/php-program/blob/master/php-htmlentitie/html_entitie.jpg)
