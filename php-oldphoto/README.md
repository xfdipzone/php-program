# php-oldphoto

php 调用 ImageMagick 实现老照片效果生成器

## 介绍

使用 `ImageMagick` 生成老照片效果，需要执行下面几个步骤

1.将输入图像使用 `sepia-tone` 滤镜处理

2.生成一个白色蒙版，填充随机噪声，转化为灰度，并加上 `alpha` 通道

3.将步骤1和步骤2的结果使用 `overlay` 的方式 `compose`

---

## 演示

```php
// 原图
$source = __DIR__ . '/source.jpg';

// 生成效果图
$dest = __DIR__ . '/dest.jpg';

// 创建效果图
$is_generated = \OldPhotoEffect\Generator::generate($source, $dest);
```

---

## 原图与生成的老照片效果对比

原图

![原图](./source.jpg)

老照片效果图

![老照片效果图](./dest.jpg)
