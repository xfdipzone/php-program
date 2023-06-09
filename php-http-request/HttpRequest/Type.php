<?php
namespace HttpRequest;

/**
 * 支持的请求数据类型
 *
 * @author fdipzone
 * @DateTime 2023-06-08 23:02:36
 *
 */
class Type
{
    // form-data
    const FORM_DATA = 'form_data';

    // 文件
    const FILE_DATA = 'file_data';

    /**
     * 类型与实现类对象关系
     *
     * @var array
     * @author fdipzone
     * @DateTime 2023-06-08 23:04:21
     *
     */
    public static $map = [
        self::FORM_DATA => 'HttpRequest\\FormData',
        self::FILE_DATA => 'HttpRequest\\FileData',
    ];
}