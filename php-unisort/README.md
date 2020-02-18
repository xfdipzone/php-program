# php-unisort

php 文件内容去重及排序

## php 实现去重及排序

```php
<?php
// 设置可使用内存为256m，可根据数据量进行设置
ini_set('memory_limit', '256m');

$source = 'user_id.txt';
$dest = 'php_sort_user_id.txt';

// 写入1000000个数字，每行一个数字
$num = 1000000;
$tmp = '';

for($i=0; $i<$num; $i++){
    $tmp .= mt_rand(0,999999).PHP_EOL;
    if($i>0 && $i%1000==0 || $i==$num-1){
        file_put_contents($source, $tmp, FILE_APPEND);
        $tmp = '';
    }
}

// 执行去重及排序
fileUniSort($source, $dest);
?>
```

查看去重及排序后的文件

```txt
wc -l php_sort_user_id.txt
  632042 php_sort_user_id.txt

head php_sort_user_id.txt
0
1
2
3
5
7
8
9
11
12
...
```

---

## linux sort命令实现去重及排序

linux sort命令用于文本文件按行排序

### 格式

```php
sort [OPTION]... [FILE]...
```

### 参数说明

`-u` 去重

`-n` 数字排序类型

`-r` 降序

`-o` 输出文件的路径

`-t` 按指定字符分割多列

`-k` 按指定列排序

### 使用sort执行去重及排序

```txt
sort -uno linux_sort_user_id.txt user_id.txt
```

查看去重及排序后的文件

```txt
wc -l linux_sort_user_id.txt
  632042 linux_sort_user_id.txt

head linux_sort_user_id.txt
0
1
2
3
5
7
8
9
11
12
...
```

---

## 总结

使用php或linux sort命令都可以实现文件去重及排序，执行时间上相差不大，但建议对于文件类的操作，直接使用系统命令实现更为简单。
