# php-sensitive-word-filter

php 敏感词过滤类

## 介绍

php 实现的敏感词过滤器，敏感词支持使用内存（数组）存储及文件存储，并设计了存储接口方便以后扩展其他存储

提供敏感词检查与过滤方法，并使用了装饰器，增加敏感词白名单保护功能，保护某些词不被过滤

---

## 功能

敏感词存储

- 存储在内存（数组）

- 存储在文件

敏感词过滤与检查

- 检查数据中是否含有敏感词

- 过滤数据中的敏感词

- 白名单保护，保护忽略被过滤的敏感词

---

## 演示

```php
// 检查是否包含敏感词
$resource = new \SensitiveWordFilter\Resource(\SensitiveWordFilter\Resource::MEMORY);
$resource->setWords(['a', 'b', 'c']);

$sensitive_word_storage = \SensitiveWordFilter\Storage\Factory::make(\SensitiveWordFilter\Storage\Type::MEMORY);
$sensitive_word_storage->setResource($resource);

$filter = new \SensitiveWordFilter\DefaultFilter($sensitive_word_storage);

$content = 'china';
var_dump($filter->isContain($content)); // true

$content = 'money';
var_dump($filter->isContain($content)); // false

// 过滤敏感词
$resource = new \SensitiveWordFilter\Resource(\SensitiveWordFilter\Resource::MEMORY);
$resource->setWords(['巴黎', '奥运', '金牌']);

$sensitive_word_storage = \SensitiveWordFilter\Storage\Factory::make(\SensitiveWordFilter\Storage\Type::MEMORY);
$sensitive_word_storage->setResource($resource);

$filter = new \SensitiveWordFilter\DefaultFilter($sensitive_word_storage);

$content = '巴黎2024奥运会，中国获得40面金牌，可喜可贺';
echo $filter->filter($content, '**'); // '**2024**会，中国获得40面**，可喜可贺';
```

更多使用详情可参考单元测试代码 [https://github.com/xfdipzone/php-program/tree/master/tests/SensitiveWordFilter](<https://github.com/xfdipzone/php-program/tree/master/tests/SensitiveWordFilter>)
