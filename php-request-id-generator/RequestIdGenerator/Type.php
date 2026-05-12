<?php
namespace RequestIdGenerator;

/**
 * 请求 ID 生成器类型
 *
 * @author fdipzone
 * @DateTime 2026-04-27 12:03:57
 *
 */
class Type
{
    // 随机 ID 生成器
    const RANDOM = 'random';

    // 雪花算法 ID 生成器
    const SNOW_FLAKE = 'snow_flake';

    // 类型与实现类对应关系
    public static $map = [
        self::RANDOM => '\RequestIdGenerator\RandomIdGenerator',
        self::SNOW_FLAKE => '\RequestIdGenerator\SnowFlakeIdGenerator',
    ];
}