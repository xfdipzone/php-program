<?php
require 'Ref.class.php';
require 'User.class.php';

echo '<pre>';
Ref::setClass('Vip');
Ref::getBase();
Ref::getProperties();
Ref::getMethods();
Ref::getInterfaces();
echo '</pre>';
?>