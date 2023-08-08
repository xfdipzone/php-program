# php-youtube-video

PHP 获取 Youtube 视频信息类

## 介绍

php 实现的获取指定 Youtube 用户所有视频信息。

---

## 功能

**getVideosInfo** 获取用户所有视频信息

**getVideosNum** 获取用户所有视频数量

**getVideoInfo** 获取单个视频信息

**getVideoIntroduction** 获取单个视频文字简介

**unescape** unicode转中文

---

## 演示

```php
require 'YoutubeVideo';

// 用户名称: GOtriphk https://www.youtube.com/user/GOtriphk/videos
$youtube_video = new YoutubeVideo('GOtriphk');
$videos_info = $youtube_video->getVideosInfo();

print_r($videos_info);
```

**输出：**

```txt
Array
(
    [0] => Array
        (
            [id] => jYDwFozp6PY
            [thumb_photo] => http://i.ytimg.com/vi/jYDwFozp6PY/default.jpg
            [middle_photo] => http://i.ytimg.com/vi/jYDwFozp6PY/mqdefault.jpg
            [big_photo] => http://i.ytimg.com/vi/jYDwFozp6PY/hqdefault.jpg
            [title] => 【比卡超ssss突襲尖咀！！！】香港比卡超展
            [content] => 香港有比卡超展，同場會展出全球最大、高13米嘅「比卡超立體飛船」，仲會有700隻唔同角色嘅精靈現身，當然亦唔小得又勁多期間限定紀念品可以優先搶以及由橫濱專程到港嘅聖誕版比卡超同粉絲全接觸，總之飛唔飛都一樣有得玩！The ONE x 寵物小精靈 聖誕夢想飛行日期:2014年11月9日至2015年1月4日時間:10am-10pm地點:The ONE UG2 中庭
            [publish_date] => 1415257662
            [length_seconds] => 124
            [view_count] => 603
            [avg_rating] => 0.0
            [embed] => //www.youtube.com/embed/jYDwFozp6PY
        )
.....
```
