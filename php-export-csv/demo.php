<?php
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