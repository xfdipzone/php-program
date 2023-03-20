<?php
require 'CartesianProduct.php';

// 定义集合
$sets = array(
    array('白色','黑色','红色'),
    array('透气','防滑'),
    array('37码','38码','39码'),
    array('男款','女款')
);

$result = CartesianProduct::cal($sets);
print_r($result);
?>