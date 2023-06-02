<?php
namespace ExportCsv;

/**
 * 导出数据源接口
 * 用于定义数据源必须实现的方法
 *
 * @author fdipzone
 * @DateTime 2023-06-01 23:20:08
 *
 */
interface IExportSource
{
    /**
     * 需要导出的总记录数
     *
     * @author fdipzone
     * @DateTime 2023-06-01 23:21:21
     *
     * @return int
     */
    public function total():int;

    /**
     * 导出数据的字段名称集合
     *
     * @author fdipzone
     * @DateTime 2023-06-01 23:21:21
     *
     * @return array
     */
    public function fields():array;

    /**
     * 获取指定范围（批次）的记录
     *
     * @author fdipzone
     * @DateTime 2023-06-01 23:21:21
     *
     * @param int $offset 偏移量
     * @param int $limit  每批次记录条数
     * @return array
     */
    public function data(int $offset, int $limit):array;
}