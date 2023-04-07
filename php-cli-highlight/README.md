# php-cli-highlight

php 实现高亮输出数据类

## 介绍

支持在 `cli模式` 下输出数据，可以设置输出数据的文字颜色，背景颜色，粗体，下划线。

非 `cli模式` 下则按原始数据输出。

---

## 演示

```php
require 'CliHighLight.php';

// 数据
$str = 'Talk is cheap. Show me the code.';

// 配置参数
$configs = [
    [CliHighLight::RED, '', true, false],
    [CliHighLight::GREEN, '', false, true],
    [CliHighLight::YELLOW, '', true, false],
    [CliHighLight::BLUE, '', false, true],
    [CliHighLight::PURPLE, '', true, false],
    [CliHighLight::CYAN, '', false, true],
    [CliHighLight::GREY, '', true, false],
    [CliHighLight::BLACK, CliHighLight::GREY, false, true],
    [CliHighLight::RED, CliHighLight::CYAN, true, false],
    [CliHighLight::GREEN, CliHighLight::PURPLE, false, true],
    [CliHighLight::YELLOW, CliHighLight::BLUE, true, false],
    [CliHighLight::BLUE, CliHighLight::YELLOW, false, true],
    [CliHighLight::PURPLE, CliHighLight::GREEN, true, false],
    [CliHighLight::CYAN, CliHighLight::RED, false, true],
    [CliHighLight::GREY, CliHighLight::BLACK, true, false],
];

foreach($configs as $config){
    echo CliHighLight::output($str, $config[0], $config[1], $config[2], $config[3]).PHP_EOL;
}
```

---

## Cli模式下效果图

![效果图](https://github.com/xfdipzone/Small-Program/blob/master/php-cli-highlight/demo.png)
