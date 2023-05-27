<?php
/**
 * php实现的导出csv抽象类
 * 根据数据集合的总记录数与设置的每批次记录数，计算总批次，循环导出所有批次数据
 *
 * 支持两种导出方式
 * - 导出到本地csv文件
 * - 导出字节流（在浏览器中直接下载）
 *
 * 抽象方法（由子类实现）
 * exportTotal      需要导出的总记录数
 * exportFieldsName 导出数据的字段名称集合(title)
 * exportData       指定范围（批次）的记录
 * 
 * @author fdipzone
 * @DateTime 2023-05-27 21:20:43
 *
 */
abstract class AbstractExportCsv
{
    /**
     * 需要导出的总记录数（由子类实现）
     *
     * @author fdipzone
     * @DateTime 2023-05-27 21:22:30
     *
     * @return int
     */
    abstract protected function exportTotal():int;

    /**
     * 导出数据的字段名称集合（由子类实现）
     *
     * @author fdipzone
     * @DateTime 2023-05-27 21:23:17
     *
     * @return array
     */
    abstract protected function exportFieldsName():array;

    /**
     * 获取指定范围（批次）的记录（由子类实现）
     *
     * @author fdipzone
     * @DateTime 2023-05-27 21:24:47
     *
     * @param int $offset 偏移量
     * @param int $limit  记录条数
     * @return array
     */
    abstract protected function exportData(int $offset, int $limit):array;

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
    public function delimiter():string{
        return $this->delimiter;
    }

    /**
     * 导出csv字节流
     *
     * @author fdipzone
     * @DateTime 2023-05-27 21:33:43
     *
     * @param string $export_name 导出的文件名称，用于浏览器下载时设置附件文件名称
     * @param int $pagesize 每批次记录数
     * @return void
     */
    final public function exportToStream(string $export_name, int $pagesize):void
    {

    }

    /**
     * 导出到本地csv文件
     *
     * @author fdipzone
     * @DateTime 2023-05-27 21:36:11
     *
     * @param string $export_file csv文件名称
     * @param int $pagesize 每批次记录数
     * @return void
     */
    final public function exportToFile(string $export_file, int $pagesize):void
    {

    }

}