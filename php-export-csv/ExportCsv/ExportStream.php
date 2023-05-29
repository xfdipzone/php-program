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