# php-metric

php计量监控类

## 介绍

php实现的计量监控类，用于统计监控指标，当指标到达指定值时，自动执行回调处理。

支持两种类型计量方式：**计数**，**计时**

---

## 功能

提供两种类型的计量方式

- 计数

  设置最大可执行次数及回调方法（可选）

  当执行次数到达指定值时，通知已到达最大执行次数，并回调（如有设置回调方法）

- 计时

  设置最大可执行秒数及回调方法（可选）

  当执行时间到达指定值时，通知已到达最大执行时间，并回调（如有设置回调方法）

---

## 演示

计数监控

```php
require 'autoload.php';

$counter_metric = new \Metric\Counter(3);
$counter_metric->setCallback(function()
{
    echo 'counter metric callback'.PHP_EOL;
});

while(true)
{
    echo 'do sth'.PHP_EOL;

    if(!$counter_metric->next())
    {
        break;
    }
}
```

计时监控

```php
require 'autoload.php';

$timer_metric = new \Metric\Timer(5);
$timer_metric->setCallback(function()
{
    echo 'timer metric callback'.PHP_EOL;
});

while(true)
{
    echo 'do sth'.PHP_EOL;
    usleep(300*1000);

    if(!$timer_metric->next())
    {
        break;
    }
}
```
