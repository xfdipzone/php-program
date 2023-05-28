<?php
namespace ExportCsv;

/**
 * 导出csv组件工厂类
 * 根据类型创建导出csv组件对象
 *
 * @author fdipzone
 * @DateTime 2023-05-28 18:20:40
 *
 */
class Factory
{
    /**
     * 根据类型创建导出csv组件对象
     *
     * @author fdipzone
     * @DateTime 2023-05-28 18:27:04
     *
     * @param \ExportCsv\Config\IExportCsvConfig $config 组件配置对象
     * @return IExportCsv
     */
    public static function make(\ExportCsv\Config\IExportCsvConfig $config):IExportCsv
    {
        try
        {
            $class = self::getExportClass($config->type());
            return new $class($config);

        }
        catch(\Throwable $e)
        {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * 根据组件类型获取组件实现类
     *
     * @author fdipzone
     * @DateTime 2023-05-28 18:23:19
     *
     * @param string $type 导出csv组件类型
     * @return string
     */
    public static function getExportClass(string $type):string
    {
        if(isset(Type::$map[$type]))
        {
            return Type::$map[$type];
        }
        else
        {
            throw new \Exception(sprintf('%s type export not exists', $type));
        }
    }
}