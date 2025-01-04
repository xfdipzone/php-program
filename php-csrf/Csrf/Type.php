<?php
namespace Csrf;

/**
 * 定义 csrf token 组件类型
 *
 * @author fdipzone
 * @DateTime 2025-01-04 11:13:55
 *
 */
class Type
{
    // internal csrf
    const INTERNAL_CSRF = 'internal_csrf';

    // 类型与实现类对应关系
    public static $map = [
        self::INTERNAL_CSRF => '\Csrf\InternalCsrf',
    ];
}