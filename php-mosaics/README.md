# php-mosaics

php 图片局部打马赛克

## 原理

对图片中选定区域的每一像素，增加若干宽度及高度，生成矩型。而每一像素的矩型重叠在一起，就形成了马赛克效果。

本方法使用GD库的`imagecolorat`获取像素颜色，使用`imagefilledrectangle`画矩型。

## Example

```php
<?php
$source = 'source.jpg';
$dest = 'dest.jpg';

$flag = imageMosaics($source, $dest, 176, 98, 273, 197, 4);
echo '<img src="'.$source.'">';
echo '<img src="'.$dest.'">';
?>
```

### 效果如下图

![原图与打马赛克后图片比较](https://github.com/xfdipzone/Small-Program/blob/master/php-mosaics/vs.jpg)
