<?php
namespace ExportCsv\Config;

/**
 * 定义导出csv组件配置接口
 *
 * @author fdipzone
 * @DateTime 2023-05-28 18:32:12
 *
 */
interface IExportCsvConfig
{
    /**
     * 获取组件配置类型
     *
     * @author fdipzone
     * @DateTime 2023-05-28 18:32:04
     *
     * @return string
     */
    public function type():string;
}