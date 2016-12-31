# php-oldphoto
php 调用imagemagick实现老照片效果

##使用imagemagick生成老照片效果，需要执行下面几个步骤
1.将输入图像使用sepia-tone滤镜处理<br>
2.生成一个白色蒙版，填充随机噪声，转化为灰度，并加上alpha通道<br>
3.将步骤1和步骤2的结果使用overlay的方式compose<br><br>

###原图与生成的老照片效果对比
原图<br>
![原图](https://github.com/xfdipzone/Small-Program/blob/master/php-oldphoto/source.jpg)
老照片<br>
![老照片](https://github.com/xfdipzone/Small-Program/blob/master/php-oldphoto/dest.jpg)