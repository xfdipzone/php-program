<?php
namespace HttpRequest;

/**
 * 定义支持的请求方法
 *
 * @author fdipzone
 * @DateTime 2023-06-08 23:22:35
 *
 */
class RequestMethod
{
    // GET 方式请求
    const GET = 'get';

    // POST 方式请求
    const POST = 'post';

    // 二进制流方式请求
    const MULTIPART = 'multipart';

    /**
     * 判断请求方法是否存在
     *
     * @author fdipzone
     * @DateTime 2023-06-08 23:23:52
     *
     * @param string $method 请求方法
     * @return boolean
     */
    public static function valid(string $method):bool
    {
        switch($method)
        {
            case self::GET:
            case self::POST:
            case self::MULTIPART:
                return true;
        }
        return false;
    }
}