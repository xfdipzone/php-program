<?php
require 'HexFileConverter.php';

$file = 'doc.txt';

// 文件转16进制串
$hex_str = HexFileConverter::fileToHex($file);

// 16进制串转文件
$new_file = 'new_doc.txt';
HexFileConverter::hexToFile($hex_str, $new_file);
?>