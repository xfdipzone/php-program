# php-spider-detector

php 爬虫机器人检测类

## 介绍

php 实现的爬虫机器人检测类，检测访问者是否爬虫机器人

通过访问者的 `user-agent` 与已知爬虫机器人列表进行匹配检测

**已知的爬虫机器人列表**（可自行增加）

```txt
TencentTraveler
Baiduspider+
BaiduGame
Googlebot
msnbot
Sosospider+
Sogou web spider
ia_archiver
Yahoo! Slurp
YoudaoBot
Yahoo Slurp
MSNBot
Java (Often spam bot)
BaiDuSpider
Voila
Yandex bot
BSpider
twiceler
Sogou Spider
Speedy Spider
Google AdSense
Heritrix
Python-urllib
Alexa (IA Archiver)
Ask
Exabot
Custo
OutfoxBot/YodaoBot
yacy
SurveyBot
legs
lwp-trivial
Nutch
StackRambler
The web archive (IA Archiver)
Perl tool
MJ12bot
Netcraft
MSIECrawler
WGet tools
larbin
Fish search
```

---

## 演示

```php
require 'SpiderDetector.php';

/**
 * 非爬虫机器人访问 curl http://localhost/demo.php
 * 爬虫机器人访问 curl --header "user-agent:Googlebot" http://localhost/demo.php
 */
$resp = SpiderDetector::isSpider();
var_dump($resp); // true: 爬虫机器人 false: 非爬虫机器人
```
