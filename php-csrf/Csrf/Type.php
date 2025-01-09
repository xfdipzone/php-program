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

    // google recaptcha v2
    const GOOGLE_RECAPTCHA_V2 = 'google_recaptcha_v2';

    // 类型与实现类对应关系
    public static $map = [
        self::INTERNAL_CSRF => '\Csrf\InternalCsrf',
        self::GOOGLE_RECAPTCHA_V2 => '\Csrf\GoogleRecaptchaV2',
    ];
}