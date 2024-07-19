<?php
require 'DataFormatter.php';

$data = array(
    'error' => 0,
    'err_msg' => '',
    'data' => array(
        'id' => 100,
        'name' => 'fdipzone',
        'gender' => 'male',
        'age' => 28,
    ),
);

$formatter = new \DataFormatter($data);
echo '输出为数组格式'.PHP_EOL;
print_r($formatter->asArray());
echo PHP_EOL;

echo '输出为 Json 格式'.PHP_EOL;
echo $formatter->asJson().PHP_EOL.PHP_EOL;

echo '输出为 XML 格式'.PHP_EOL;
echo $formatter->asXML().PHP_EOL.PHP_EOL;

echo '输出为 Js Callback 格式'.PHP_EOL;
echo $formatter->asJsCallback('callback');