<?php
namespace  ExportCsv\Config;

/**
 * 导出字节流组件配置类
 *
 * @author fdipzone
 * @DateTime 2023-05-28 18:34:13
 *
 */
class ExportStreamConfig implements IExportCsvConfig
{
    /**
     * 组件配置类型
     *
     * @var string
     */
    private $type = \ExportCsv\Type::STREAM;

    /**
     * 导出的文件名称
     * 用于浏览器下载时设置附件文件名称
     *
     * @var string
     */
    private $export_name;

    /**
     * 每批次导出数量
     *
     * @var int
     */
    private $pagesize;

    /**
     * 初始化
     *
     * @author fdipzone
     * @DateTime 2023-05-28 19:40:56
     *
     * @param string $export_name 导出的文件名称，用于浏览器下载时设置附件文件名称
     * @param int $pagesize 每批次导出数量
     */
    public function __construct(string $export_name, int $pagesize)
    {
        if(empty($export_name))
        {
            throw new \Exception('export name is empty');
        }

        if(empty($pagesize) || !is_numeric($pagesize) || $pagesize<0)
        {
            throw new \Exception('pagesize error');
        }

        $this->export_name = $export_name;
        $this->pagesize = $pagesize;
    }

    /**
     * 获取组件配置类型
     *
     * @author fdipzone
     * @DateTime 2023-05-28 18:36:33
     *
     * @return string
     */
    public function type():string
    {
        return $this->type;
    }

    /**
     * 导出的文件名称
     *
     * @author fdipzone
     * @DateTime 2023-05-28 19:46:08
     *
     * @return string
     */
    public function exportName():string
    {
        return $this->export_name;
    }

    /**
     * 获取每批次导出数量
     *
     * @author fdipzone
     * @DateTime 2023-05-28 19:46:19
     *
     * @return int
     */
    public function pagesize():int
    {
        return $this->pagesize;
    }

}