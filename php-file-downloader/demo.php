<?php
require 'FileDownloader.php';

$file = dirname(__FILE__).'/demo.zip';
$downloader = new FileDownloader(256, true); // true: 开启断点续传 false: 关闭断点续传
$downloader->download($file, 'new_demo.zip');