# php-trafficshaper

php 基于redis使用令牌桶算法实现流量控制

## 令牌桶算法

1.首先设有一个令牌桶，桶内存放令牌，一开始令牌桶内的令牌是满的（桶内令牌的数量可根据服务器情况设定）。

2.每次访问从桶内取走一个令牌，当桶内令牌为0，则不允许再访问。

3.每隔一段时间，再放入令牌，最多使桶内令牌满额。（可以根据实际情况，每隔一段时间放入若干个令牌，或直接补满令牌桶）

本类使用redis的队列作为令牌桶容器使用，使用lPush（入队），rPop（出队），实现令牌加入与消耗的操作。

---

## 定期加入令牌算法

定期加入令牌，使用crontab实现，每分钟调用add方法加入若干令牌。

crontab最小的执行间隔为1分钟，如果令牌桶内的令牌在前几秒就已经被消耗完，那么剩下的几十秒时间内，都获取不到令牌，导致用户等待时间较长。

我们可以优化加入令牌的算法，改为一分钟内每若干秒加入若干令牌，这样可以保证一分钟内每段时间都有机会能获取到令牌。

---

## 演示

```php
<?php
/**
 * 演示令牌加入与消耗
 */
require 'TrafficShaper.class.php';

// redis连接设定
$config = array(
    'host' => 'localhost',
    'port' => 6379,
    'index' => 0,
    'auth' => '',
    'timeout' => 1,
    'reserved' => NULL,
    'retry_interval' => 100,
);

// 令牌桶容器
$queue = 'mycontainer';

// 最大令牌数
$max = 5;

// 创建TrafficShaper对象
$oTrafficShaper = new TrafficShaper($config, $queue, $max);

// 重设令牌桶，填满令牌
$oTrafficShaper->reset();

// 循环获取令牌，令牌桶内只有5个令牌，因此最后3次获取失败
for($i=0; $i<8; $i++){
    var_dump($oTrafficShaper->get());
}

// 加入10个令牌，最大令牌为5，因此只能加入5个
$add_num = $oTrafficShaper->add(10);

var_dump($add_num);

// 循环获取令牌，令牌桶内只有5个令牌，因此最后1次获取失败
for($i=0; $i<6; $i++){
    var_dump($oTrafficShaper->get());
}

?>
```

输出：

```txt
boolean true
boolean true
boolean true
boolean true
boolean true
boolean false
boolean false
boolean false
int 5
boolean true
boolean true
boolean true
boolean true
boolean true
boolean false
```
