<?php
require 'IdCode.php';

$test_ids = array(1, 9, 10, 99, 100, 999, 1000, 1009, 2099, 3999, 9999, 14999, 25999, 26000, 99999);

foreach($test_ids as $test_id)
{
    echo $test_id.' = '. IdCode::create($test_id, 3, 'F').PHP_EOL;
}