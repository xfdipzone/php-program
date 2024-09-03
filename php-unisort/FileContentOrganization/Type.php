<?php
namespace FileContentOrganization;

/**
 * 定义处理器类型
 *
 * @author fdipzone
 * @DateTime 2023-03-23 22:37:39
 *
 */
class Type{

    // 去重
    const UNIQUE = 'unique';

    // 排序
    const SORT = 'sort';

    // 类型与实现类对应关系
    public static $map = [
        self::UNIQUE => '\FileContentOrganization\Handler\Unique',
        self::SORT => '\FileContentOrganization\Handler\Sort',
    ];

}