# php-backoff

php退避算法类

## 介绍

php实现的退避算法类，退避算法是一种用于处理临时故障的重试机制，通过在连续失败后增加等待重试时间来控制重试频率

本类实现了指数退避算法（Exponential Backoff）

---

## 功能

根据配置，计算是否需要重试及下次重试的时间间隔

**配置包括：**

- 初始重试等待时间间隔

- 最大重试等待时间间隔

- 指数退避因子（倍数）

- 最大重试次数

- 随机因子

**计算规则：**

如果超过了 `最大重试次数`，返回不再重试，不计算重试等待时间间隔

如果计算出的 `重试等待时间间隔` 超过设置的 `最大重试等待时间间隔`，则使用最大重试等待时间间隔（封顶）

最大重试等待时间间隔由 `初始重试等待时间间隔`, `指数退避因子`, `已重试次数`, `随机因子` 进行计算得出

---

## 演示

```php
require 'autoload.php';

// 配置参数
$start_retry_interval = 5;
$factor = 2;
$max_retry_interval = 300;
$max_retry_times = 8;
$random_factor = 3;

// 指数退避算法
$exponential_backoff = new \Backoff\ExponentialBackoff($start_retry_interval, $max_retry_interval, $factor, $max_retry_times);
$exponential_backoff->setRandomFactor($random_factor);

for($i=0; $i<9; $i++)
{
    $request = new \Backoff\Request($i);
    $response = $exponential_backoff->next($request);
    printf("retry_times=%d, retry=%b, retry_interval=%d\n", $i, $response->retry(), $response->retryInterval());
}
```
