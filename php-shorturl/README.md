# php-shorturl

php 调用新浪API生成短链接

## 新浪生成短链接API介绍

新浪提供了长链接转为短链接的API，可以把长链接转为 `t.cn/xxx` 这种格式的短链接。

### API

<http://api.t.sina.com.cn/short_url/shorten.json> (返回结果是JSON格式)

<http://api.t.sina.com.cn/short_url/shorten.xml> （返回结果是XML格式）

### 请求参数

source    申请应用时分配的AppKey，调用接口时代表应用的唯一身份。

url_long  需要转换的长链接，需要URLencoded，最多不超过20个。

多个url参数需要使用如下方式请求：**url_long=aaa&url_long=bbb**

### 创建source方法

1.进入<http://open.weibo.com/> ，选择菜单 微连接->网站接入。

2.点击立即接入，创建新应用，随便填写应用名称，点击创建。

3.创建成功后且审核通过后，AppKey就是source参数的值，可以用于请求创建短链接。

---

## 演示

```php
// AppKey
$api_key = '您申请的AppKey';

// 链接转换
$urls = array(
    'http://blog.csdn.net/fdipzone/article/details/46390573',
    'http://blog.csdn.net/fdipzone/article/details/12180523',
    'http://blog.csdn.net/fdipzone/article/details/9316385'
);

$config = array(
    'api_key' => $api_key
);
$generator = ShortUrlGenerator\Generator::make(ShortUrlGenerator\Type::SINA, $config);
$result = $generator->generate($urls);

print_r($result);
```

输出：

```txt
Array
(
    [0] => Array
        (
            [url_short] => http://t.cn/R4qB08y
            [url_long] => http://blog.csdn.net/fdipzone/article/details/46390573
            [type] => 0
        )

    [1] => Array
        (
            [url_short] => http://t.cn/RGgNanY
            [url_long] => http://blog.csdn.net/fdipzone/article/details/12180523
            [type] => 0
        )

    [2] => Array
        (
            [url_short] => http://t.cn/R7TrNWZ
            [url_long] => http://blog.csdn.net/fdipzone/article/details/9316385
            [type] => 0
        )

)
```
