# php-db-model

php 数据库表 Model 类

## 介绍

php 实现的数据库表 Model 类，通过类属性注解定义字段列设置，生成创建数据库表的SQL语句

基于 `\AnnotationReader\AnnotationReader` 实现类属性注解读取

可用于自动化测试时，在测试环境重建数据库表结构

---

## 功能

- 定义数据库表 Model 结构

- 解析类属性注解，生成创建表的SQL语句

---

## 类说明

**IDbModel** `DbModel/IDbModel.php`

数据库表 Model 类 接口，定义 Model 需要实现的方法

**AbstractDbModel** `DbModel/AbstractDbModel.php`

数据库表 Model 抽象父类，提供默认方法实现

**Constants** `DbModel/Constants.php`

定义通用常量

**DbModelReader** `DbModel/DbModelReader.php`

数据库表 Model 阅读器，读取 Model 方法及属性注解，生成创建表 SQL

**ColumnParser** `DbModel/ColumnParser.php`

Model 字段列解析器，用于根据设置创建字段列 SQL

---

## 演示

[演示的 User Model 类文件](<../tests/DbModel/TestModel/User.php>)

```php
$user = new User;
$sql = \DbModel\DbModelReader::generateCreateTableSql($user);
echo $sql;
```

更多功能演示可参考单元测试代码 [DbModel Unit Test](<../tests/DbModel>)
