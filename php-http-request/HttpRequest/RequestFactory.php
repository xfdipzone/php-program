<?php
namespace HttpRequest;

/**
 * 请求工厂类，用于根据请求方式执行请求
 *
 * @author fdipzone
 * @DateTime 2023-06-12 22:36:48
 *
 */
class RequestFactory
{
    /**
     * 根据请求方式执行请求
     *
     * @author fdipzone
     * @DateTime 2023-06-12 22:44:44
     *
     * @param resource $fp http连接
     * @param \HttpRequest\RequestSet $request_set 请求对象集合
     * @param string $request_method 请求方式
     * @return \HttpRequest\Response
     */
    public static function request($fp, \HttpRequest\RequestSet $request_set, string $request_method):\HttpRequest\Response
    {
        try
        {
            $handle_func = self::handleFunc($request_method);
            return self::$handle_func($fp, $request_set);
        }
        catch(\Throwable $e)
        {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * 根据请求方式获取请求处理方法
     *
     * @author fdipzone
     * @DateTime 2023-06-12 22:38:04
     *
     * @param string $request_method 请求方式，在 \HttpRequest\RequestMethod 中定义
     * @return string
     */
    private static function handleFunc(string $request_method):string
    {
        switch($request_method)
        {
            case \HttpRequest\RequestMethod::GET:
                return 'sendGet';
            case \HttpRequest\RequestMethod::POST:
                return 'sendPost';
            case \HttpRequest\RequestMethod::MULTIPART:
                return 'sendMultiPart';
            default:
                throw new \Exception('request method error');
        }
    }

    /**
     * 以 GET 方式执行请求
     *
     * @author fdipzone
     * @DateTime 2023-06-12 22:24:54
     *
     * @param resource $fp http连接
     * @param \HttpRequest\RequestSet $request_set 请求对象集合
     * @return \HttpRequest\Response
     */
    private static function sendGet($fp, \HttpRequest\RequestSet $request_set):\HttpRequest\Response
    {
        $response = new \HttpRequest\Response;
        return $response;
    }

    /**
     * 以 POST 方式执行请求
     *
     * @author fdipzone
     * @DateTime 2023-06-12 22:29:26
     *
     * @param resource $fp http连接
     * @param \HttpRequest\RequestSet $request_set 请求对象集合
     * @return \HttpRequest\Response
     */
    private static function sendPost($fp, \HttpRequest\RequestSet $request_set):\HttpRequest\Response
    {
        $response = new \HttpRequest\Response;
        return $response;
    }

    /**
     * 以二进制流方式执行请求
     *
     * @author fdipzone
     * @DateTime 2023-06-12 22:29:05
     *
     * @param resource $fp http连接
     * @param \HttpRequest\RequestSet $request_set 请求对象集合
     * @return \HttpRequest\Response
     */
    private static function sendMultiPart($fp, \HttpRequest\RequestSet $request_set):\HttpRequest\Response
    {
        $response = new \HttpRequest\Response;
        return $response;
    }
}