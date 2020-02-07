# php-ffmpeg

php 调用ffmpeg获取视频信息

## 介绍

ffmpeg是一套可以用来记录、转换数字音频、视频，并能将其转化为流的开源计算机程序，包含了libavcodec，保证高可移值性和编解码质量。

本程序使用php调用ffmpeg获取视频信息，调用ffmpeg首先需要服务器上安装了ffmpeg，安装方法很简单，可自行搜索。

---

## 执行结果

```txt
Array
(
    [duration] => 00:33:42.64
    [seconds] => 2022.64
    [start] => 0.000000
    [bitrate] => 152
    [vcodec] => rv20 (RV20 / 0x30325652)
    [vformat] => yuv420p
    [resolution] => 352x288
    [width] => 352
    [height] => 288
    [acodec] => cook (cook / 0x6B6F6F63)
    [asamplerate] => 22050
    [play_time] => 2022.64
    [size] => 38630744
)
```
