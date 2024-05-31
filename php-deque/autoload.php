<?php
/**
 * 自动加载类文件
 *
 * @author fdipzone
 * @DateTime 2024-05-31 10:53:36
 *
 * @param string $class 类名称
 * @return void
 */
function class_auto_loader($class):void
{
    $class = trim($class, '\\');
    $class_file = '';

    if(strpos($class, 'DEQue\\') === 0)
    {
        $class_file = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'DEQue' . DIRECTORY_SEPARATOR . str_replace('\\', '/', str_replace('DEQue\\', '', $class)) . '.php';
    }
    else
    {
        $class_file = dirname(__FILE__) . DIRECTORY_SEPARATOR . str_replace('\\', '/', $class) . '.php';
    }

    if (!empty($class_file) && file_exists($class_file))
    {
        include_once $class_file;
    }
}
spl_autoload_register('class_auto_loader', true, true);