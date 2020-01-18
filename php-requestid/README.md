# php-requestid

PHP生成唯一RequestID类

## 介绍

PHP生成唯一RequestID类，使用`session_create_id()`与`uniqid()`方法，保证唯一性。

### 使用场景

现在的系统设计一般使用分布式系统，一个请求可能要调用几个微服务处理，最后再把结果返回。当请求出现问题时，我们很难去跟踪是哪个微服务出现问题。

每个请求访问服务器时，我们可以给这个访问加入一个唯一标识（RequestID)，在请求开始，请求过程中，及请求结束时，把这个请求流程关键的数据写入日志（例如访问时的参数，经过那些方法，微服务，结束时返回的数据等），当访问出现问题时用于参考，方便追踪到问题。

例如一个请求需要经过几个微服务再返回输出

请求->A->B->C-A->输出

如果访问过程没有输出，或输出错误，我们可以根据 `RequestID` 找到A,B,C对应的日志，检查是哪个服务出现问题。

## 演示

```php
<?php
require 'RequestID.class.php';

// 生成10个请求id
for($i=0; $i<10; $i++){
    echo RequestID::generate().PHP_EOL;
}
?>
```

输出：

```txt
16532925-4502-CDAD-23A2-463FC7B5803A
500B77AD-CD24-0DDA-9E6E-2FDF2DD7CA94
813143D0-958F-9F56-E04F-679598594452
E5EE1B0B-E0D6-3E60-D831-462C5A262FCE
79E714B5-A37F-4B5E-4EDE-83E18391EBF9
E1C440AB-FC2C-AC74-E79A-016FD59D9651
AE483861-1040-BE8D-E523-D7638D0F0D35
BBD7A03A-36C9-24B7-C453-FB1DDD6E201E
BF62C3E6-9C5F-22CB-668D-381863B35268
E97E1F44-F048-962A-5BF7-1113727551B1
```

## 注意

注意`session_create_id`方法需要`php7.1`以上的版本才可使用。
