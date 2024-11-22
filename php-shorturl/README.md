# php-shorturl

php 调用新浪API生成短链接

## 新浪生成短链接API介绍

新浪提供了长链接转为短链接的API，可以把长链接转为 `t.cn/xxx` 这种格式的短链接。

> 新浪微博开放平台已将此接口功能下线
> [https://open.weibo.com/wiki/Short_url/shorten](<https://open.weibo.com/wiki/Short_url/shorten>)

可以使用另一个接口替代 [https://open.weibo.com/wiki/C/2/short_url/shorten/biz](<https://open.weibo.com/wiki/C/2/short_url/shorten/biz>)

使用此接口需要开发者级别为 **合作伙伴**

> 合作伙伴，除了默认获得普通开发者所有的以上三种资源权限外，还有可能获得 **媒体发布类高级接口、博文评论内容类高级接口、内容流SDK、`短（外）链跳转服务、网页呼端能力、数据推送服务** 等资源权限，具体视合作情况而定。

### API

<https://api.t.sina.com.cn/short_url/shorten.json> (返回结果是JSON格式)

<https://api.t.sina.com.cn/short_url/shorten.xml> （返回结果是XML格式）

### 请求参数

source    申请应用时分配的AppKey，调用接口时代表应用的唯一身份。

url_long  需要转换的长链接，需要URLencoded，最多不超过20个。

多个url参数需要使用如下方式请求：**url_long=aaa&url_long=bbb**

### 创建source方法

1.进入<http://open.weibo.com/> ，选择菜单 微连接->网站接入。

2.点击立即接入，创建新应用，随便填写应用名称，点击创建。

3.创建成功且审核通过后，AppKey就是source参数的值，可以用于请求创建短链接。

如未审核通过，则会有以下错误提示

```txt
Array
(
    [request] => /short_url/shorten.json
    [error_code] => 403
    [error] => 40358:applications over the unaudited use restrictions!
)
```

---

## 演示

```php
// AppKey
$app_key = '您申请的AppKey';

// 长链接
$urls = array(
    'https://blog.csdn.net/fdipzone/article/details/46390573',
    'https://blog.csdn.net/fdipzone/article/details/12180523',
    'https://blog.csdn.net/fdipzone/article/details/9316385'
);

// 生成短链接
$config = array(
    'app_key' => $app_key
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
