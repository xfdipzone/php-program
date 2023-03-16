<?php
require 'Ref.php';
require 'User.php';

Ref::setClass('Vip');

$base_info = Ref::getBase();
$properties = Ref::getProperties();
$methods = Ref::getMethods();
$interfaces = Ref::getInterfaces();

$class_info = array(
    'base_info' => $base_info,
    'properties' => $properties,
    'methods' => $methods,
    'interfaces' => $interfaces,
);

echo json_encode($class_info, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
?>