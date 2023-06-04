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
        // 获取总记录数
        $total = $source->total();

        if(!$total)
        {
            return ;
        }

        // 计算导出总批次
        $page_count = (int)(($total-1)/$this->config->pagesize())+1;

        // 创建导出目录
        $this->createExportFolder($this->config->exportFile());

        $export_data = '';

        // 导出字段名
        $fields = $source->fields();
        $title_data = \ExportCsv\ExportFormatter::format($fields, $this->config->separator(), $this->config->delimiter());
        file_put_contents($this->config->exportFile(), $title_data, FILE_APPEND);

        // 循环导出
        for($i=0; $i<$page_count; $i++)
        {
            $export_data = '';

            // 获取每页数据
            $offset = $i*$this->config->pagesize();
            $page_data = $source->data($offset, $this->config->pagesize());

            // 转为csv格式
            if($page_data)
            {
                foreach($page_data as $row)
                {
                    $export_data .= \ExportCsv\ExportFormatter::format($row, $this->config->separator(), $this->config->delimiter());
                }
            }

            file_put_contents($this->config->exportFile(), $export_data, FILE_APPEND);
        }
    }

    /**
     * 创建导出目录
     *
     * @author fdipzone
     * @DateTime 2023-06-03 00:03:48
     *
     * @param string $file 导出文件路径
     * @return boolean
     */
    private function createExportFolder(string $file):bool
    {
        if(!is_dir(dirname($file)))
        {
            return mkdir(dirname($file), 0777, true);
        }

        return true;
    }
}