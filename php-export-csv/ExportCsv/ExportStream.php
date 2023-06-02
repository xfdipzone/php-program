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
     * @param \ExportCsv\IExportSource $source 数据源对象
     * @return void
     */
    public function export(\ExportCsv\IExportSource $source):void
    {
        // 获取总记录数
        $total = $source->total();

        // 计算导出总批次
        $page_count = $total>0? (int)(($total-1)/$this->config->pagesize()) : 0;

        // 设置导出header
        $this->setHeader();

        $export_data = '';

        // 导出字段名
        $fields = $source->fields();
        $export_data .= \ExportCsv\ExportFormatter::format($fields, $this->config->separator(), $this->config->delimiter());

        // 循环导出
        for($i=0; $i<$page_count; $i++)
        {
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

            echo $export_data;
        }

    }

    /**
     * 设置导出字节流header
     *
     * @author fdipzone
     * @DateTime 2023-05-29 22:19:16
     *
     * @return void
     */
    private function setHeader():void
    {
        header('content-type:application/x-msexcel');

        // 根据不同浏览器设置header
        $user_agent = isset($_SERVER['HTTP_USER_AGENT'])? $_SERVER['HTTP_USER_AGENT'] : '';

        if(preg_match("/MSIE/", $user_agent))
        {
            header('content-disposition:attachment; filename="'.rawurlencode($this->config->exportName()).'"');
        }
        elseif(preg_match("/Firefox/", $user_agent))
        {
            header("content-disposition:attachment; filename*=\"utf8''".$this->config->exportName().'"');
        }
        else
        {
            header('content-disposition:attachment; filename="'.$this->config->exportName().'"');
        }

        ob_end_flush();
        ob_implicit_flush(true);
    }
}