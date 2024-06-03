<?php
require 'autoload.php';

$de_queue = new \DEQue\Queue(\DEQue\Type::UNRESTRICTED, 10);
$de_queue->pushFront(new \DEQue\Item('a'));
$de_queue->pushFront(new \DEQue\Item('b'));
$de_queue->pushFront(new \DEQue\Item('c'));
$de_queue->pushFront(new \DEQue\Item('d'));
$de_queue->pushFront(new \DEQue\Item('e'));

$resp = $de_queue->popFront();
echo $resp->item()->data().PHP_EOL; // e

$resp = $de_queue->popFront();
echo $resp->item()->data().PHP_EOL; // d

$resp = $de_queue->popFront();
echo $resp->item()->data().PHP_EOL; // c

$resp = $de_queue->popRear();
echo $resp->item()->data().PHP_EOL; // a

$resp = $de_queue->popRear();
echo $resp->item()->data().PHP_EOL; // b
