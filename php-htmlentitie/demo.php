<?php
require 'HtmlEntitie.class.php';

$str = '<p>更多资讯可关注本人微信号：fdipzone-idea</p><p><img border="0" src="http://img.blog.csdn.net/20141224160911852" width="180" height="180" title="破晓领域"></p><p>您的支持是我最大的动力，谢谢！</p>';

echo '<meta http-equiv="content-type" content="text/html;charset=utf-8">';

// 字符串转为HTML实体编号
echo '字符串转为HTML实体编号'.PHP_EOL;
$cstr = HtmlEntitie::encode($str);
echo $cstr.PHP_EOL.PHP_EOL;

// HTML实体编号转为字符串
echo 'HTML实体编号转为字符串'.PHP_EOL;
echo HtmlEntitie::decode($cstr);

?>