<?php
namespace ExportCsv\Config;

/**
 * 定义导出csv组件配置抽象类
 *
 * @author fdipzone
 * @DateTime 2023-05-31 23:28:44
 *
 */
abstract class AbstractExportCsvConfig
{
    /**
     * 组件配置类型
     *
     * @var string
     */
    protected $type;

    /**
     * 每批次导出数量
     *
     * @var int
     */
    protected $pagesize;

    /**
     * 分隔符（用于字段间数据分隔）
     *
     * @var string
     */
    private $separator = ',';

    /**
     * 定界符（用于定义字段数据边界）
     *
     * @var string
     */
    private $delimiter = '"';

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

    /**
     * 设置分隔符
     *
     * @author fdipzone
     * @DateTime 2023-05-27 21:45:05
     *
     * @param string $separator 分隔符
     * @return void
     */
    public function setSeparator(string $separator):void
    {
        if(empty($separator))
        {
            throw new \Exception('separator is empty');
        }
        $this->separator = $separator;
    }

    /**
     * 获取分隔符
     *
     * @author fdipzone
     * @DateTime 2023-05-27 21:47:49
     *
     * @return string
     */
    public function separator():string
    {
        return $this->separator;
    }

    /**
     * 设置定界符
     *
     * @author fdipzone
     * @DateTime 2023-05-27 21:45:27
     *
     * @param string $delimiter 定界符
     * @return void
     */
    public function setDelimiter(string $delimiter):void
    {
        if(empty($delimiter))
        {
            throw new \Exception('delimiter is empty');
        }
        $this->delimiter = $delimiter;
    }

    /**
     * 获取定界符
     *
     * @author fdipzone
     * @DateTime 2023-05-27 21:48:19
     *
     * @return string
     */
    public function delimiter():string
    {
        return $this->delimiter;
    }
}