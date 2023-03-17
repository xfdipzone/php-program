# php-reflection

php 利用反射API获取类信息

## PHP反射API介绍

PHP具有完整的反射API，可以对类、接口、函数、方法和扩展进行反向工程。反射API并提供方法取出函数、类和方法中的文档注释。

PHP反射API文档地址：<http://php.net/manual/zh/class.reflectionclass.php>

---

## 使用ReflectionClass获取类的属性，接口，方法等信息

### 1.获取类基本信息

```php
$ref = new ReflectionClass($class_name);
echo $ref->getName();
echo $ref->getFileName();
```

### 2.获取类属性信息

```php
$ref = new ReflectionClass($class_name);
$properties = $ref->getProperties();
foreach($properties as $property){
    echo $property->getName();
}
```

### 3.获取类方法信息

```php
$ref = new ReflectionClass($class_name);
$methods = $ref->getMethods();
foreach($methods as $method){
    echo $method->getName();
}
```

### 4.获取类接口信息

```php
$ref = new ReflectionClass($class_name);
$interfaces = $ref->getInterfaces();
foreach($interfaces as $interface){
    echo $interface->getName();
}
```

---

## 演示

```php
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
```

输出：

```json
{
    "base_info": {
        "className": "Vip",
        "classPath": "\/home\/fdipzone\/php-reflection",
        "classFileName": "User.php"
    },
    "properties": [
        {
            "propertyName": "user",
            "propertyModifier": "protected",
            "propertyComments": "用户数据"
        }
    ],
    "methods": [
        {
            "methodName": "getVip",
            "methodModifier": "public",
            "methodParamsNum": 1,
            "methodParams": [
                "id"
            ],
            "methodComments": "读取vip用户数据"
        },
        {
            "methodName": "format",
            "methodModifier": "private",
            "methodParamsNum": 1,
            "methodParams": [
                "data"
            ],
            "methodComments": "修饰数据"
        },
        {
            "methodName": "add",
            "methodModifier": "public",
            "methodParamsNum": 1,
            "methodParams": [
                "data"
            ],
            "methodComments": "新增用户"
        },
        {
            "methodName": "get",
            "methodModifier": "public",
            "methodParamsNum": 1,
            "methodParams": [
                "id"
            ],
            "methodComments": "读取用户数据"
        }
    ],
    "interfaces": [
        "IUser"
    ]
}
```
