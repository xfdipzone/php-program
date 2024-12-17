# php-annotation-reader

php 注解阅读器

## 介绍

php 实现的类注解阅读器，用于获取类文件的 `类`，`属性`，`方法` 注解

基于 **ReflectionClass**（反射）实现

[https://www.php.net/manual/zh/class.reflectionclass.php](<https://www.php.net/manual/zh/class.reflectionclass.php>)

---

## 功能

获取类文件的 `类`，`属性`，`方法` 中指定标签的注解

---

## 类说明

**IAnnotationReader** `AnnotationReader/IAnnotationReader.php`

注解阅读器接口，定义注解阅读器类必须实现的方法

**AnnotationTags** `AnnotationReader/AnnotationTags.php`

需要解析的注解标签集合

**AnnotationReader** `AnnotationReader/AnnotationReader.php`

注解阅读器，基于 ReflectionClass（反射）实现

---

## 演示

[演示的 User 类文件](<../tests/AnnotationReader/User.php>)

```php
$user = new User('fdipzone', 18, 'programmer');
$annotation_reader = new \AnnotationReader\AnnotationReader($user);

$class_tags = new \AnnotationReader\AnnotationTags(['@description']);
$class_annotations = $annotation_reader->classAnnotation($class_tags);
print_r($class_annotations);

$properties_tags = new \AnnotationReader\AnnotationTags(['@Column', '@Tag']);
$properties_annotations = $annotation_reader->propertiesAnnotation($properties_tags);
print_r($properties_annotations);

$methods_tags = new \AnnotationReader\AnnotationTags(['@description']);
$methods_annotations = $annotation_reader->methodsAnnotation($methods_tags);
print_r($methods_annotations);
```

更多功能演示可参考单元测试代码 [AnnotationReader Unit Test](<../tests/AnnotationReader>)
