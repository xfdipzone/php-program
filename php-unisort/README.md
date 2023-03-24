# php-unisort

php 文件内容去重及排序

## 介绍

php 实现文件内容去重及排序，针对每行内容为一个整体的处理，使用到职责链模式。

可以设置需要的处理器对文件内容进行处理。

`\FileContentOrganization\Organizer`

程序入口，用于设置处理器对象，及调用处理器执行，生成处理后的文件。

`\FileContentOrganization\Type`

定义支持的处理器类型，及类型对应的实现类。

`\FileContentOrganization\IHandler`

文件内容处理器类接口，定义文件内容处理器类需要实现的功能。

`\FileContentOrganization\Factory`

文件内容处理器工厂类，用于创建不同类型的处理器类对象。

`\FileContentOrganization\Handler\Unique`

文件内容去重处理器类

`\FileContentOrganization\IHandler\Sort`

文件内容排序处理器类

---

## 演示

```php
// 源文件及目标文件
$source = 'user_id.txt';
$dest = 'php_sort_user_id.txt';

// 创建处理器对象
$unique_handler = \FileContentOrganization\Factory::make(\FileContentOrganization\Type::UNIQUE);

$sort_handler = \FileContentOrganization\Factory::make(\FileContentOrganization\Type::SORT);
$sort_handler->setOrder('desc'); // 设置降序
$sort_handler->setSortFlag(SORT_NUMERIC); // 设置按数字类型排序

// 创建文件内容整理对象
$organizer = new \FileContentOrganization\Organizer($source, $dest);
$organizer->addHandler($unique_handler);
$organizer->addHandler($sort_handler);
$organizer->handle();
?>
```

查看去重及排序后的文件

```txt
wc -l php_sort_user_id.txt
     999 php_sort_user_id.txt

head php_sort_user_id.txt
999
998
997
996
995
994
993
992
991
990
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
     999 linux_sort_user_id.txt

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
