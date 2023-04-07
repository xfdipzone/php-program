<?php
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
?>