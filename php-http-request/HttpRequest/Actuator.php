<?php
namespace HttpRequest;

/**
 * HttpRequest 请求执行器
 * 用于根据配置执行http请求
 *
 * @author fdipzone
 * @DateTime 2023-06-07 22:56:37
 *
 */
class Actuator
{
    /**
     * 请求连接配置
     *
     * @var \HttpRequest\Connect\Config
     */
    private $config;

    /**
     * 初始化，传入配置
     *
     * @author fdipzone
     * @DateTime 2023-06-07 22:57:26
     *
     * @param \HttpRequest\Connect\Config $config 请求连接配置
     */
    public function __construct(\HttpRequest\Connect\Config $config)
    {
        $this->config = $config;
    }

    /**
     * 执行，发送请求数据
     *
     * @author fdipzone
     * @DateTime 2023-06-08 23:16:12
     *
     * @param string $url 请求的路径
     * @param \HttpRequest\RequestSet $request_set 请求对象集合
     * @param string $method 请求方式，在 \HttpRequest\RequestMethod 中定义
     * @return \HttpRequest\Response
     */
    public function send(string $url, \HttpRequest\RequestSet $request_set, string $request_method):\HttpRequest\Response
    {
        try
        {
            // 验证请求方式
            if(!\HttpRequest\RequestMethod::valid($request_method))
            {
                throw new \Exception('request method error');
            }

            // 创建连接器对象，创建http连接
            $connector = new \HttpRequest\Connect\Connector;
            $fp = $connector->connect($this->config->host(), $this->config->port(), $this->config->timeout());

            // 生成http请求数据
            $http_request_data = \HttpRequest\RequestFactory::generate($this->config->host(), $url, $request_set, $request_method);

            // 执行请求
            $response = $this->httpRequest($fp, $http_request_data);

            // 断开连接
            $connector->disconnect();

            return $response;
        }
        catch(\Throwable $e)
        {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * 执行http请求，返回执行结果
     *
     * @author fdipzone
     * @DateTime 2023-06-14 23:19:27
     *
     * @param resource $fp http连接
     * @param string $http_request_data http请求数据
     * @return \HttpRequest\Response
     */
    private function httpRequest($fp, string $http_request_data):\HttpRequest\Response
    {
        try
        {
            $http_response = '';

            fputs($fp, $http_request_data);

            while($row=fread($fp, 4096))
            {
                $http_response .= $row;
            }

            // 删除http连接相关数据，只获取返回内容
            $pos = strpos($http_response, "\r\n\r\n");
            $http_response = substr($http_response, $pos+4);

            $response = new \HttpRequest\Response;
            $response->success(true);
            $response->data($http_response);
        }
        catch(\Throwable $e)
        {
            $response = new \HttpRequest\Response;
            $response->success(false);
            $response->errMsg($e->getMessage());
        }

        return $response;
    }
}