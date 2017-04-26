# php-shorturl
php 调用新浪API生成短链接

## 新浪生成短链接API介绍

新浪提供了长链接转为短链接的API，可以把长链接转为 <font color="#FF0000">t.cn/xxx</font> 这种格式的短链接。<br><br>

### API：
http://api.t.sina.com.cn/short_url/shorten.json (返回结果是JSON格式)<br>
http://api.t.sina.com.cn/short_url/shorten.xml （返回结果是XML格式）<br>

### 请求参数：
source    申请应用时分配的AppKey，调用接口时代表应用的唯一身份。<br>
url_long  需要转换的长链接，需要URLencoded，最多不超过20个。<br>
多个url参数需要使用如下方式请求：url_long=aaa&url_long=bbb<br><br>

### 创建source方法
1.进入http://open.weibo.com/ ，选择菜单 微连接->网站接入。<br>
2.点击立即接入，创建新应用，随便填写应用名称，点击创建。<br>
3.创建成功后，AppKey就是source参数的值，可以用于请求创建短链接。<br><br>

## 演示

```php
// AppKey
$source = '您申请的AppKey';

// 单个链接转换
$url_long = 'http://blog.csdn.net/fdipzone';

$data = getSinaShortUrl($source, $url_long);
print_r($data);

// 多个链接转换
$url_long = array(
    'http://blog.csdn.net/fdipzone/article/details/46390573',
    'http://blog.csdn.net/fdipzone/article/details/12180523',
    'http://blog.csdn.net/fdipzone/article/details/9316385'
);

$data = getSinaShortUrl($source, $url_long);
print_r($data);
```

输出：

```txt
Array
(
    [0] => Array
        (
            [url_short] => http://t.cn/RyVmU5i
            [url_long] => http://blog.csdn.net/fdipzone
            [type] => 0
        )

)

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
