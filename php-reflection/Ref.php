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

    private static $refClass = null;

    // 设置反射类
    public static function setClass(string $class_name):void{
        self::$refClass = new ReflectionClass($class_name);
    }

    // 读取类基本信息
    public static function getBase():array{
        return array(
            'className' => self::$refClass->getName(),
            'classPath' => dirname(self::$refClass->getFileName()),
            'classFileName' => basename(self::$refClass->getFileName()),
        );
    }

    // 读取类接口
    public static function getInterfaces():array{
        $ret = [];
        $interfaces = self::$refClass->getInterfaces();
        if($interfaces){
            foreach($interfaces as $interface){
                $ret[] = $interface->getName();
            }
        }
        return $ret;
    }

    // 读取类属性
    public static function getProperties():array{
        $ret = [];
        $properties = self::$refClass->getProperties();
        if($properties){
            foreach($properties as $property){
                $tmp = array(
                    'propertyName' => $property->getName(),
                    'propertyModifier' => self::getModifier($property),
                    'propertyComments' => self::formatComment($property->getDocComment()),
                );
                $ret[] = $tmp;
            }
        }
        return $ret;
    }

    // 读取类方法
    public static function getMethods():array{
        $ret = [];
        $methods = self::$refClass->getMethods();
        if($methods){
            foreach($methods as $method){
                $tmp = array(
                    'methodName' => $method->getName(),
                    'methodModifier' => self::getModifier($method),
                    'methodParamsNum' => $method->getNumberOfParameters(),
                    'methodParams' => [],
                    'methodComments' => self::formatComment($method->getDocComment()),
                );
                $params = $method->getParameters();
                if($params){
                    foreach($params as $param){
                        $tmp['methodParams'][] = $param->getName();
                    }
                }
                $ret[] = $tmp;
            }
        }
        return $ret;
    }

    // 获取修饰符 ReflectionMethod/ReflectionProperty Reflector
    private static function getModifier($o):string{
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
    private static function formatComment(string $comment):string{
        $doc = explode(PHP_EOL, $comment);
        return isset($doc[1])? trim(str_replace('*','',$doc[1])) : '';
    }

} // class end
?>