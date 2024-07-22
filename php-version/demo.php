<?php
require 'Version.php';

// 版本转数字
$version = '2.7.1';
$version_number = Version::versionToInteger($version);
echo $version_number.PHP_EOL; // 20701

// 数字转版本
$version_number = 20701;
$version = Version::integerToVersion($version_number);
echo $version.PHP_EOL; // 2.7.1

// 检查版本
$version = '1.1.1';
var_dump(Version::validate($version)); // true

$version = '1.1.a';
var_dump(Version::validate($version)); // false

// 比较两个版本
$version1 = '1.0.0';
$version2 = '1.0.0';
echo Version::compare($version1, $version2).PHP_EOL; // 0

$version1 = '1.0.1';
$version2 = '1.0.0';
echo Version::compare($version1, $version2).PHP_EOL; // 1

$version1 = '0.99.99';
$version2 = '1.0.0';
echo Version::compare($version1, $version2).PHP_EOL; // -1