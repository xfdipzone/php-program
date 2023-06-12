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
     * @var \HttpRequest\Config
     */
    private $config;

    /**
     * 初始化，传入配置
     *
     * @author fdipzone
     * @DateTime 2023-06-07 22:57:26
     *
     * @param \HttpRequest\Config $config 请求连接配置
     */
    public function __construct(\HttpRequest\Config $config)
    {
        $this->config = $config;
    }

    /**
     * 执行，发送请求数据
     *
     * @author fdipzone
     * @DateTime 2023-06-08 23:16:12
     *
     * @param \HttpRequest\RequestSet $request_set 请求对象集合
     * @param string $method 请求方式，在 \HttpRequest\RequestMethod 中定义
     * @return \HttpRequest\Response
     */
    public function send(\HttpRequest\RequestSet $request_set, string $request_method):\HttpRequest\Response
    {
        try
        {
            // 验证请求方式
            if(!\HttpRequest\RequestMethod::valid($request_method))
            {
                throw new \Exception('request method error');
            }

            // 创建连接器对象，创建http连接
            $connector = new \HttpRequest\Connector;
            $fp = $connector->connect($this->config->host(), $this->config->port(), $this->config->timeout());

            // 执行请求
            $response = \HttpRequest\RequestFactory::request($fp, $request_set, $request_method);

            // 断开连接
            $connector->disconnect();

            return $response;
        }
        catch(\Throwable $e)
        {
            throw new \Exception($e->getMessage());
        }
    }
}