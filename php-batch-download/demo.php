<?php
require 'BatchDownLoad.class.php';

$base_path = dirname(__FILE__).'/photo';

$download_config = array(
    array('http://www.example.com/p1.jpg', $base_path.'/p1.jpg'),
    array('http://www.example.com/p2.jpg', $base_path.'/p2.jpg'),
    array('http://www.example.com/p3.jpg', $base_path.'/p3.jpg'),
    array('http://www.example.com/p4.jpg', $base_path.'/p4.jpg'),
    array('http://www.example.com/p5.jpg', $base_path.'/p5.jpg'),
);

$obj = new BatchDownLoad($download_config, 2, 10);
$handle_num = $obj->download();

echo 'download num:'.$handle_num.PHP_EOL;
?>