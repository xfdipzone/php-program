<?php
namespace ExportCsv\Config;

/**
 * 导出本地文件组件配置类
 *
 * @author fdipzone
 * @DateTime 2023-05-28 18:34:13
 *
 */
class ExportFileConfig implements IExportCsvConfig
{
    /**
     * 组件配置类型
     *
     * @var string
     */
    private $type = \ExportCsv\Type::FILE;

    /**
     * csv文件路径
     *
     * @var string
     */
    private $export_file;

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
     * @param string $export_file csv文件路径
     * @param int $pagesize 每批次导出数量
     */
    public function __construct(string $export_file, int $pagesize)
    {
        if(empty($export_file))
        {
            throw new \Exception('export file is empty');
        }

        if(empty($pagesize) || !is_numeric($pagesize) || $pagesize<0)
        {
            throw new \Exception('pagesize error');
        }

        $this->export_file = $export_file;
        $this->pagesize = $pagesize;
    }

    /**
     * 获取组件配置类型
     *
     * @author fdipzone
     * @DateTime 2023-05-28 18:36:20
     *
     * @return string
     */
    public function type():string
    {
        return $this->type;
    }

    /**
     * 获取csv文件路径
     *
     * @author fdipzone
     * @DateTime 2023-05-28 19:46:08
     *
     * @return string
     */
    public function exportFile():string
    {
        return $this->export_file;
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