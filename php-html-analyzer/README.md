# php-html-analyzer

php HTML文档分析类

## 介绍

php 实现的 HTML 文档分析类，用于分析 HTML 文档，根据配置获取内容中所需数据，例如：url, email, image 等

---

## 功能

- 获取 HTML 文档中的 Email 集合

- 获取 HTML 文档中的 URL 集合

- 获取 HTML 文档中的图片集合

- 获取 HTML 文档中的 CSS 集合

---

## 类说明

**Document** `HtmlAnalyzer/Document.php`

HTML 文档结构

**Analyzer** `HtmlAnalyzer/Analyzer.php`

HTML 文档分析器（代码入口）

**Type** `HtmlAnalyzer/Type.php`

支持的 HTML 文档解析类型

**IParser** `HtmlAnalyzer/DocumentParser/IParser.php`

HTML 文档解析器接口

**EmailParser** `HtmlAnalyzer/DocumentParser/EmailParser.php`

Email 解析器，用于获取 HTML 文档中的 Email 集合

**UrlParser** `HtmlAnalyzer/DocumentParser/UrlParser.php`

Url 解析器，用于获取 HTML 文档中的 URL 集合

**ImageParser** `HtmlAnalyzer/DocumentParser/ImageParser.php`

图片解析器，用于获取 HTML 文档中的图片集合

**CssParser** `HtmlAnalyzer/DocumentParser/CssParser.php`

CSS 解析器，用于获取 HTML 文档中的 CSS 集合

---

## 演示

```php
$url = 'https://www.sina.com.cn';
$doc = file_get_contents($url);
$document = new \HtmlAnalyzer\Document($url, $doc);

$analyzer = new \HtmlAnalyzer\Analyzer($document);
$emails = $analyzer->getResource(\HtmlAnalyzer\Type::EMAIL);
$urls = $analyzer->getResource(\HtmlAnalyzer\Type::URL);
$images = $analyzer->getResource(\HtmlAnalyzer\Type::IMAGE);
$css = $analyzer->getResource(\HtmlAnalyzer\Type::CSS);

print_r($emails);
print_r($urls);
print_r($images);
print_r($css);
```

更多功能演示可参考单元测试代码 [HtmlAnalyzer Unit Test](<../tests/HtmlAnalyzer>)
