<?php
require 'RequestIdGenerator.php';

// 生成10个请求id
for($i=0; $i<10; $i++){
    echo RequestIdGenerator::generate().PHP_EOL;
}
?>