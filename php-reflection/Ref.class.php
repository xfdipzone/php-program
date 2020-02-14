<?php
/**
 * 调用PHP反射类获取类信息
 * Date:    2017-05-24
 * Author:  fdipzone
 * Ver:     1.0
 *
 * Func
 * public static setClass       设置反射类
 * public static getBase        读取类基本信息
 * public static getInterfaces  读取类接口
 * public static getProperties  读取类属性
 * public static getMethods     读取类方法
 */
class Ref{ // class start

    private static $refclass = null;

    // 设置反射类
    public static function setClass($classname){
        self::$refclass = new ReflectionClass($classname);
    }

    // 读取类基本信息
    public static function getBase(){
        echo '<strong>BASE INFO</strong>'.PHP_EOL;
        echo 'class name: '.self::$refclass->getName().PHP_EOL;
        echo 'class path: '.dirname(self::$refclass->getFileName()).PHP_EOL;
        echo 'class filename: '.basename(self::$refclass->getFileName()).PHP_EOL.PHP_EOL;
    }

    // 读取类接口
    public static function getInterfaces(){
        echo '<strong>INTERFACES INFO</strong>'.PHP_EOL;
        $interfaces = self::$refclass->getInterfaces();
        if($interfaces){
            foreach($interfaces as $interface){
                echo 'interface name: '.$interface->getName().PHP_EOL;
            }
        }
    }

    // 读取类属性
    public static function getProperties(){
        echo '<strong>PROPERTIES INFO</strong>'.PHP_EOL;
        $properties = self::$refclass->getProperties();
        if($properties){
            foreach($properties as $property){
                echo 'property name: '.$property->getName().PHP_EOL;
                echo 'property modifier: '.self::getModifier($property).PHP_EOL;
                echo 'property comments: '.self::formatComment($property->getDocComment()).PHP_EOL.PHP_EOL;
            }
        }
    }

    // 读取类方法
    public static function getMethods(){
        echo '<strong>METHODS INFO</strong>'.PHP_EOL;
        $methods = self::$refclass->getMethods();
        if($methods){
            foreach($methods as $method){
                echo 'method name: '.$method->getName().PHP_EOL;
                echo 'method modifier: '.self::getModifier($method).PHP_EOL;
                echo 'method params num: '.$method->getNumberOfParameters().PHP_EOL;
                $params = $method->getParameters();
                if($params){
                    foreach($params as $param){
                        echo 'param name:'.$param->getName().PHP_EOL;
                    }
                }
                echo 'method comments: '.self::formatComment($method->getDocComment()).PHP_EOL.PHP_EOL;
            }
        }
    }

    // 获取修饰符
    private static function getModifier($o){
        // public
        if($o->isPublic()){
            return 'public';
        }

        // protected
        if($o->isProtected()){
            return 'protected';
        }

        // private
        if($o->isPrivate()){
            return 'private';
        }

        return '';
    }

    // 格式化注释内容
    private static function formatComment($comment){
        $doc = explode(PHP_EOL, $comment);
        return isset($doc[1])? trim(str_replace('*','',$doc[1])) : '';
    }

} // class end
?>