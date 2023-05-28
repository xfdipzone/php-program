<?php
namespace ExportCsv;

/**
 * 导出csv到字节流组件
 *
 * @author fdipzone
 * @DateTime 2023-05-28 23:01:30
 *
 */
class ExportStream implements IExportCsv
{
    /**
     * 组件配置对象
     *
     * @var \ExportCsv\Config\ExportStreamConfig
     */
    private $config;

    /**
     * 初始化
     *
     * @author fdipzone
     * @DateTime 2023-05-28 23:01:49
     *
     * @param \ExportCsv\Config\IExportCsvConfig $config 组件配置对象
     */
    public function __construct(\ExportCsv\Config\IExportCsvConfig $config)
    {
        if(get_class($config)!='ExportCsv\Config\ExportStreamConfig')
        {
            throw new \Exception('config type error');
        }

        $this->config = $config;
    }

    /**
     * 执行导出
     *
     * @author fdipzone
     * @DateTime 2023-05-28 23:01:53
     *
     * @return void
     */
    public function export():void
    {

    }
}