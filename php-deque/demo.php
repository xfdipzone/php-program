<?php
require 'autoload.php';

// 没有限制
$de_queue = new \DEQue\Queue(\DEQue\Type::UNRESTRICTED, 10);
$de_queue->pushFront(new \DEQue\Item('a'));
$de_queue->pushRear(new \DEQue\Item('b'));
$de_queue->pushFront(new \DEQue\Item('c'));
$de_queue->pushRear(new \DEQue\Item('d'));
$de_queue->pushFront(new \DEQue\Item('e'));

$resp = $de_queue->popFront();
assert($resp->item()->data()=='e');

$resp = $de_queue->popFront();
assert($resp->item()->data()=='c');

$resp = $de_queue->popFront();
assert($resp->item()->data()=='a');

$resp = $de_queue->popRear();
assert($resp->item()->data()=='d');

$resp = $de_queue->popRear();
assert($resp->item()->data()=='b');

// 队列已满
$de_queue = new \DEQue\Queue(\DEQue\Type::UNRESTRICTED, 2);
$resp = $de_queue->pushFront(new \DEQue\Item('a'));
assert($resp->error()==0);

$resp = $de_queue->pushFront(new \DEQue\Item('b'));
assert($resp->error()==0);

$resp = $de_queue->pushFront(new \DEQue\Item('c'));
assert($resp->error()==\DEQue\ErrCode::FULL);

// 队列为空
$de_queue = new \DEQue\Queue(\DEQue\Type::UNRESTRICTED, 2);
$resp = $de_queue->popFront();
assert($resp->error()==\DEQue\ErrCode::EMPTY);

$resp = $de_queue->popRear();
assert($resp->error()==\DEQue\ErrCode::EMPTY);

// 头部入队限制
$de_queue = new \DEQue\Queue(\DEQue\Type::FRONT_ONLY_OUT, 10);
$resp = $de_queue->pushFront(new \DEQue\Item('a'));
assert($resp->error()==\DEQue\ErrCode::FRONT_ENQUEUE_RESTRICTED);

// 头部出队限制
$de_queue = new \DEQue\Queue(\DEQue\Type::FRONT_ONLY_IN, 10);
$de_queue->pushFront(new \DEQue\Item('a'));
$resp = $de_queue->popFront();
assert($resp->error()==\DEQue\ErrCode::FRONT_DEQUEUE_RESTRICTED);
$resp = $de_queue->popRear();
assert($resp->error()==0);
assert($resp->item()->data()=='a');

// 尾部入队限制
$de_queue = new \DEQue\Queue(\DEQue\Type::REAR_ONLY_OUT, 10);
$resp = $de_queue->pushRear(new \DEQue\Item('a'));
assert($resp->error()==\DEQue\ErrCode::REAR_ENQUEUE_RESTRICTED);

// 尾部出队限制
$de_queue = new \DEQue\Queue(\DEQue\Type::REAR_ONLY_IN, 10);
$de_queue->pushRear(new \DEQue\Item('a'));
$resp = $de_queue->popRear();
assert($resp->error()==\DEQue\ErrCode::REAR_DEQUEUE_RESTRICTED);
$resp = $de_queue->popFront();
assert($resp->error()==0);
assert($resp->item()->data()=='a');

// 入队与出队方向一致限制
$de_queue = new \DEQue\Queue(\DEQue\Type::SAME_IN_OUT, 10);
$de_queue->pushFront(new \DEQue\Item('a'));
$resp = $de_queue->popRear();
assert($resp->error()==\DEQue\ErrCode::DIFFERENT_ENDPOINT);
$resp = $de_queue->popFront();
assert($resp->error()==0);
assert($resp->item()->data()=='a');