<?php
namespace ExportCsv;

/**
 * 导出csv到本地文件组件
 *
 * @author fdipzone
 * @DateTime 2023-05-28 23:01:15
 *
 */
class ExportFile implements IExportCsv
{
    /**
     * 组件配置对象
     *
     * @var \ExportCsv\Config\ExportFileConfig
     */
    private $config;

    /**
     * 初始化
     *
     * @author fdipzone
     * @DateTime 2023-05-28 23:02:16
     *
     * @param \ExportCsv\Config\IExportCsvConfig $config 组件配置对象
     */
    public function __construct(\ExportCsv\Config\IExportCsvConfig $config)
    {
        if(get_class($config)!='ExportCsv\Config\ExportFileConfig')
        {
            throw new \Exception('config type error');
        }

        $this->config = $config;
    }

    /**
     * 执行导出
     *
     * @author fdipzone
     * @DateTime 2023-05-28 23:02:38
     *
     * @param \ExportCsv\IExportSource $source 数据源对象
     * @return void
     */
    public function export(\ExportCsv\IExportSource $source):void
    {

    }
}