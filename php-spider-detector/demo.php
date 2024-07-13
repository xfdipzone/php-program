<?php
require 'SpiderDetector.php';

/**
 * 非爬虫机器人访问 curl http://localhost/demo.php
 * 爬虫机器人访问 curl --header "user-agent:Googlebot" http://localhost/demo.php
 */
$resp = SpiderDetector::isSpider();
var_dump($resp);