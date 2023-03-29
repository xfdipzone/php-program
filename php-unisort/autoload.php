<?php
/**
 * 自动加载类文件
 *
 * @author fdipzone
 * @DateTime 2023-03-22 22:31:25
 *
 * @param string $class
 * @return void
 */
function class_autoloader($class):void{
    $class = trim($class, '\\');
    $class_file = '';

    if(strpos($class, 'FileContentOrganization\\') === 0){
        $class_file = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'FileContentOrganization' . DIRECTORY_SEPARATOR . str_replace('\\', '/', str_replace('FileContentOrganization\\', '', $class)) . '.php';
    }else{
        $class_file = dirname(__FILE__) . DIRECTORY_SEPARATOR . str_replace('\\', '/', $class) . '.php';
    }

    if (!empty($class_file) && file_exists($class_file)){
        include_once $class_file;
    }
}
spl_autoload_register('class_autoloader', true, true);