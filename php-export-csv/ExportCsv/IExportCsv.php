<?php
namespace ExportCsv;

/**
 * 定义导出csv组件接口
 *
 * @author fdipzone
 * @DateTime 2023-05-28 18:19:20
 *
 */
interface IExportCsv
{

    /**
     * 初始化
     *
     * @author fdipzone
     * @DateTime 2023-05-28 19:58:38
     *
     * @param \ExportCsv\Config\IExportCsvConfig $config 组件配置对象
     */
    public function __construct(\ExportCsv\Config\IExportCsvConfig $config);

    /**
     * 执行导出
     *
     * @author fdipzone
     * @DateTime 2023-05-28 18:20:06
     *
     * @return void
     */
    public function export():void;
}