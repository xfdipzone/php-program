# php-reflection
php 利用反射API获取类信息

## PHP反射API介绍

PHP具有完整的反射API，可以对类、接口、函数、方法和扩展进行反向工程。反射API并提供方法取出函数、类和方法中的文档注释。<br>

PHP反射API文档地址：http://php.net/manual/zh/class.reflectionclass.php<br>

## 使用ReflectionClass获取类的属性，接口，方法等信息

### 1.获取类基本信息

```php
$ref = new ReflectionClass($classname);
echo $ref->getName();
echo $ref->getFileName();
```

### 2.获取类属性信息

```php
$ref = new ReflectionClass($classname);
$properties = $ref->getProperties();
foreach($properties as $property){
    echo $property->getName();
}
```

### 3.获取类方法信息

```php
$ref = new ReflectionClass($classname);
$methods = $ref->getMethods();
foreach($methods as $method){
    echo $method->getName();
}
```

### 4.获取类接口信息

```php
$ref = new ReflectionClass($classname);
$interfaces = $ref->getInterfaces();
foreach($interfaces as $interface){
    echo $interface->getName();
}
```

## 演示

```php
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
```

输出：

```txt
BASE INFO
class name: Vip
class path: /home/fdipzone/ref
class filename: User.class.php

PROPERTIES INFO
property name: user
property modifier: protected
property comments: 用户数据

METHODS INFO
method name: getvip
method modifier: public
method params num: 1
param name:id
method comments: 读取vip用户数据

method name: format
method modifier: private
method params num: 1
param name:data
method comments: 修饰数据

method name: add
method modifier: public
method params num: 1
param name:data
method comments: 新增用户

method name: get
method modifier: public
method params num: 1
param name:id
method comments: 读取用户数据

INTERFACES INFO
interface name: IUser
```
