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

    /**
     * 获取每批次导出数量
     *
     * @author fdipzone
     * @DateTime 2023-06-05 00:13:49
     *
     * @return int
     */
    public function pagesize():int;

    /**
     * 获取分隔符
     *
     * @author fdipzone
     * @DateTime 2023-05-31 23:25:44
     *
     * @return string
     */
    public function separator():string;

    /**
     * 设置定界符
     *
     * @author fdipzone
     * @DateTime 2023-05-31 23:25:47
     *
     * @return string
     */
    public function delimiter():string;
}