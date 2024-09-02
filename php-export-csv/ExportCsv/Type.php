<?php
namespace ExportCsv;

/**
 * 定义导出csv组件类型
 *
 * @author fdipzone
 * @DateTime 2023-05-28 18:08:11
 *
 */
class Type
{
    // 导出字节流
    const STREAM = 'Stream';

    // 导出本地文件
    const FILE = 'File';

    // 类型与实现类对象关系
    public static $map = [
        self::STREAM => '\ExportCsv\ExportStream',
        self::FILE => '\ExportCsv\ExportFile'
    ];
}