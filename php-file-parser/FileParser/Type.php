<?php
namespace FileParser;

/**
 * 解析器类型
 *
 * @author fdipzone
 * @DateTime 2024-09-02 17:32:09
 *
 */
class Type
{
    // XML 类型
    const XML = 'xml';

    // 类型与实现类对应关系
    public static $map = [
        self::XML => '\FileParser\XmlParser',
    ];
}