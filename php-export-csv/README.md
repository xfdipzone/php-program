# php-export-csv

php导出csv类

## 介绍

php实现的导出csv类，根据数据集合的总记录数与设置的每批次导出数量，计算总批次，循环导出所有批次数据

---

## 功能

可自定义 **分隔符(separator)** 与 **定界符(delimiter)**

支持两种导出方式

- 导出到本地csv文件

- 导出字节流（在浏览器中直接下载）

---

## 演示

```php
require 'autoload.php';

// 数据源对象
$data_source = new DataSource;

// 导出配置(导出字节流)
$config = new \ExportCsv\Config\ExportStreamConfig('export_stream.csv', 5);

// 导出对象(stream)
$export_handler = \ExportCsv\Factory::make($config);

// 执行导出
$export_handler->export($data_source);

// 导出配置(导出文件)
$config = new \ExportCsv\Config\ExportFileConfig('/tmp/export_file.csv', 5);

// 导出对象(file)
$export_handler = \ExportCsv\Factory::make($config);

// 执行导出
$export_handler->export($data_source);
```
