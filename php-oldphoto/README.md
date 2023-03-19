# php-oldphoto

php 调用imagemagick实现老照片效果

## 介绍

使用 `imagemagick` 生成老照片效果，需要执行下面几个步骤

1.将输入图像使用 sepia-tone 滤镜处理

2.生成一个白色蒙版，填充随机噪声，转化为灰度，并加上alpha通道

3.将步骤1和步骤2的结果使用overlay的方式compose

---

## 演示

```php
// 原图
$source = dirname(__FILE__).'/source.jpg';

// 效果图
$dest = dirname(__FILE__).'/dest.jpg';

// 创建效果图
$is_create = OldPhotoEffect::create($source, $dest);
```

---

## 原图与生成的老照片效果对比

原图

![原图](https://github.com/xfdipzone/Small-Program/blob/master/php-oldphoto/source.jpg)

老照片效果图

![老照片效果图](https://github.com/xfdipzone/Small-Program/blob/master/php-oldphoto/dest.jpg)
