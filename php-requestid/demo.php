<?php
require 'RequestID.class.php';

// 生成10个请求id
for($i=0; $i<10; $i++){
    echo RequestID::generate().PHP_EOL;
}

?>