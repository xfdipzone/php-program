# php-file-parser

php 文件解析类

## 介绍

php 实现的文件解析类，支持将文件或字符串解析为 PHP 数组格式，用于代码中执行

暂时只支持解析 XML 文件及 XML 格式的字符串为数组

设计了文件解析器接口 `\FileParser\IFileParser` 方便以后扩展其他文件解析器

---

## 功能

- 解析文件

  将文件解析为数组

- 解析字符串

  将字符串解析为数组

---

## 类说明

**Factory** `FileParser/Factory.php`

文件解析器工厂类，用于生成文件解析器实例

**IFileParser** `FileParser/IFileParser.php`

文件解析器接口，定义文件解析器必须实现的方法

**Type** `FileParser/Type.php`

定义支持的文件解析器类型

**XmlParser** `FileParser/XmlParser.php`

XML 文件解析器

**Response** `FileParser/Response.php`

定义解析器输出结构

---

## 演示

file.xml

```xml
<?xml version="1.0" encoding="utf-8"?>
<xmlroot>
<status>1000</status>
<info></info>
<result><id>100</id>
<name>fdipzone</name>
<gender>1</gender>
<age>28</age>
</result>
</xmlroot>
```

```php
// 解析 XML 文件
$xml_file = 'file.xml';
$xml_parser = \FileParser\Factory::make(\FileParser\Type::XML);
$response = $xml_parser->parseFromFile($xml_file);
print_r($response->data());

// 解析 XML 字符串
$xml_string = '<?xml version="1.0" encoding="utf-8"?>
<xmlroot>
<status>1000</status>
<info></info>
<result><id>100</id>
<name>fdipzone</name>
<gender>1</gender>
<age>28</age>
</result>
</xmlroot>';

$xml_parser = \FileParser\Factory::make(\FileParser\Type::XML);
$response = $xml_parser->parseFromString($xml_string);
print_r($response->data());
```

更多功能演示可参考单元测试代码 [FileParser Unit Test](<https://github.com/xfdipzone/php-program/tree/master/tests/FileParser>)
