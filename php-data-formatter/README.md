# php-data-formatter

php 数据格式化类

## 介绍

php 实现的数据格式化类，支持将原始数据格式化为 `Json`, `XML`, `Array`, `Js Callback` 格式输出

---

## 功能

支持将原始数据格式化为以下格式输出

例：原始数据

```php
$data = array(
    'id' => 1001,
    'name' => 'fdipzone',
);
```

**数组格式 (Array)：**

```txt
Array
(
    [id] => 1001
    [name] => fdipzone
)
```

**Json 格式：**

```json
{
    "id": 1001,
    "name": "fdipzone"
}
```

**XML 格式：**

```xml
<?xml version="1.0" encoding="utf-8"?>
<root>
  <id>1001</id>
  <name>fdipzone</name>
</root>
```

**Js Callback 格式：**

```javascript
callback_func({"id":1001,"name":"fdipzone"});
```

---

## 演示

```php
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
echo $formatter->asXml().PHP_EOL.PHP_EOL;

echo '输出为 Js Callback 格式'.PHP_EOL;
echo $formatter->asJsCallback('callback');
```
