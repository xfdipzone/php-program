# php-timer

php 执行时间统计类

## 介绍

php 实现的代码执行时间统计类，计算流程总执行时间及流程中各个时间事件的执行时间

---

## 功能

- 采集

  采集时间事件，包括开始事件与结束事件

- 存储

  存储时间事件集合到时间线

- 分析统计

  分析时间线，统计流程总执行时间与各个时间事件执行时间

---

## 类说明

**Collector** `Timer/Collector.php`

采集器，用于采集时间事件，生成时间线

**Event** `Timer/Event.php`

时间事件，包含事件开始执行时间与事件说明

**Timeline** `Timer/Timeline.php`

时间线，用于按顺序存储时间事件集合

**Statistic** `Timer/Statistic.php`

分析器，用于分析时间线，计算总执行时间与各个时间事件执行时间

---

## 演示

```php
// 采集器
$collector = new \Timer\Collector;

// 随机 sleep 20 ~ 100 ms 模拟代码执行
$collector->start();
usleep(mt_rand(10000, 100000));

$collector->savePoint('event1');
usleep(mt_rand(10000, 100000));

$collector->savePoint('event2');
usleep(mt_rand(10000, 100000));

$collector->savePoint('event3');
usleep(mt_rand(10000, 100000));

$collector->end();

// 获取采集结果时间线
$timeline = $collector->timeline();

// 分析时间线
$statistic = new \Timer\Statistic($timeline);

// 输出总执行时间
printf("total execute time: %s ms \n", $statistic->totalTime());

// 打印明细执行时间
print_r($statistic->detailTime());
```

更多功能演示可参考单元测试代码 [Timer Unit Test](<https://github.com/xfdipzone/php-program/tree/master/tests/Timer>)
