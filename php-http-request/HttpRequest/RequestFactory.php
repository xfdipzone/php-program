<?php
namespace HttpRequest;

/**
 * 请求工厂类，用于根据请求方式生成请求数据
 *
 * @author fdipzone
 * @DateTime 2023-06-12 22:36:48
 *
 */
class RequestFactory
{
    /**
     * 根据请求方式生成请求数据
     *
     * @author fdipzone
     * @DateTime 2023-06-12 22:44:44
     *
     * @param string $host 请求的host/ip地址
     * @param string $url 请求的路径
     * @param \HttpRequest\RequestSet $request_set 请求对象集合
     * @param string $request_method 请求方式
     * @return string
     */
    public static function generate(string $host, string $url, \HttpRequest\RequestSet $request_set, string $request_method):string
    {
        try
        {
            $handle_func = self::handleFunc($request_method);
            return self::$handle_func($host, $url, $request_set);
        }
        catch(\Throwable $e)
        {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * 根据请求方式获取请求数据生成方法
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
     * 生成以 GET 方式的请求数据
     * 此方式只能生成form-data，不生成file-data的请求数据
     *
     * @author fdipzone
     * @DateTime 2023-06-12 22:24:54
     *
     * @param string $host 请求的host/ip地址
     * @param string $url 请求的路径
     * @param \HttpRequest\RequestSet $request_set 请求对象集合
     * @return string
     */
    private static function sendGet(string $host, string $url, \HttpRequest\RequestSet $request_set):string
    {
        // 整理请求数据
        $form_data = $request_set->convertFormDataSet();

        // 检查是否空数据
        if(!$form_data)
        {
            throw new \Exception('send data is empty');
        }

        // 生成GET方式http请求数据
        $url_with_params = $url.'?'.http_build_query($form_data);

        $out = "GET ".$url_with_params." http/1.1\r\n";
        $out .= "host: ".$host."\r\n";
        $out .= "connection: close\r\n\r\n";

        return $out;
    }

    /**
     * 生成以 POST 方式的请求数据
     *
     * @author fdipzone
     * @DateTime 2023-06-12 22:29:26
     *
     * @param string $host 请求的host/ip地址
     * @param string $url 请求的路径
     * @param \HttpRequest\RequestSet $request_set 请求对象集合
     * @return string
     */
    private static function sendPost(string $host, string $url, \HttpRequest\RequestSet $request_set):string
    {
        // 整理请求数据
        $form_data = $request_set->convertFormDataSet();
        $file_data = $request_set->convertFileDataSet();

        // 检查是否空数据
        if(!$form_data && !$file_data)
        {
            throw new \Exception('send data is empty');
        }

        $send_data = $form_data? $form_data : array();

        // file data
        if($file_data)
        {
            foreach($file_data as $file)
            {
                if(file_exists($file['file_path']))
                {
                    $send_data[$file['upload_field_name']] = file_get_contents($file['file_path']);
                }
            }
        }

        // 生成POST方式http请求数据
        $post_data = http_build_query($send_data);

        $out = "POST ".$url." http/1.1\r\n";
        $out .= "host: ".$host."\r\n";
        $out .= "content-type: application/x-www-form-urlencoded\r\n";
        $out .= "content-length: ".strlen($post_data)."\r\n";
        $out .= "connection: close\r\n\r\n";
        $out .= $post_data;

        return $out;
    }

    /**
     * 生成以二进制流方式的请求数据
     *
     * @author fdipzone
     * @DateTime 2023-06-12 22:29:05
     *
     * @param string $host 请求的host/ip地址
     * @param string $url 请求的路径
     * @param \HttpRequest\RequestSet $request_set 请求对象集合
     * @return string
     */
    private static function sendMultiPart(string $host, string $url, \HttpRequest\RequestSet $request_set):string
    {
        return '';
    }
}