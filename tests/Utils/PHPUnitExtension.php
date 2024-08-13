<?php declare(strict_types=1);
namespace TestUtils;

/**
 * PHP Unit 扩展类
 *
 * 提供 PHP Unit 扩展的方法
 * 基于反射调用 protected/private 方法，调用 protected/private 静态方法等
 *
 * @author fdipzone
 * @DateTime 2024-08-13 16:43:17
 *
 */
class PHPUnitExtension
{
    /**
     * 调用对象的 protected/private 方法
     * 利用 Reflection 反射实现
     *
     * @author fdipzone
     * @DateTime 2024-08-13 16:43:17
     *
     * @param object $obj  类对象
     * @param string $name 方法名称
     * @param array $args  方法参数
     * @return mixed
     */
    public static function callMethod($obj, $name, array $args)
    {
        $class = new \ReflectionClass($obj);
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method->invokeArgs($obj, $args);
    }

    /**
     * 调用类的 protected/private 静态方法
     * 利用 Reflection 反射实现
     *
     * @author fdipzone
     * @DateTime 2024-08-13 16:43:17
     *
     * @param string $class_name 类名称
     * @param string $name       方法名称
     * @param array $args        方法参数
     * @return mixed
     */
    public static function callStaticMethod($class_name, $name, array $args)
    {
        $class = new \ReflectionClass($class_name);
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method->invokeArgs(null, $args);
    }

    /**
     * 设置对象 protected/private 属性的值
     * 利用 Reflection 反射实现
     *
     * @author fdipzone
     * @DateTime 2024-08-13 16:43:17
     *
     * @param object $obj  类对象
     * @param string $var  属性名称
     * @param mixed $value 属性值
     * @return void
     */
    public static function setVariable($obj, $var, $value)
    {
        $rp = new \ReflectionProperty($obj, $var);
        $rp->setAccessible(true);
        $rp->setValue($obj, $value);
    }

    /**
     * 获取对象 protected/private 属性的值
     * 利用 Reflection 反射实现
     *
     * @author fdipzone
     * @DateTime 2024-08-13 16:43:17
     *
     * @param object $obj 类对象
     * @param string $var 属性名称
     * @return mixed
     */
    public static function getVariable($obj, $var)
    {
        $rp = new \ReflectionProperty($obj, $var);
        $rp->setAccessible(true);
        return $rp->getValue($obj);
    }

    /**
     * 设置类的 protected/private 静态属性
     * 利用 Reflection 反射实现
     *
     * @author fdipzone
     * @DateTime 2024-08-13 16:43:17
     *
     * @param string $class_name 类名称
     * @param string $var        属性名称
     * @param mixed $value       属性值
     * @return void
     */
    public static function setStaticVariable($class_name, $var, $value)
    {
        $reflection = new \ReflectionClass($class_name);
        $property = $reflection->getProperty($var);
        $property->setAccessible(true);
        $new_obj = new $class_name;
        $property->setValue($new_obj, $value);
    }

    /**
     * 获取类的 protected/private 静态属性
     * 利用 Reflection 反射实现
     *
     * @author fdipzone
     * @DateTime 2024-08-13 16:43:17
     *
     * @param string $class_name 类名称
     * @param string $var        属性名称
     * @return mixed
     */
    public static function getStaticVariable($class_name, $var)
    {
       $reflection = new \ReflectionClass($class_name);
       $property = $reflection->getProperty($var);
       $property->setAccessible(true);
       $new_obj = new $class_name;
       return $property->getValue($new_obj);
    }
}