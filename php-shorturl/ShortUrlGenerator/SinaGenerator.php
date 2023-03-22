<?php
namespace ShortUrlGenerator;

/**
 * 基于新浪API实现短链接生成器
 *
 * @author fdipzone
 * @DateTime 2023-03-22 22:00:43
 *
 */
class SinaGenerator implements IGenerator{

    /**
     * 新浪生成短链接接口
     *
     * @var string
     */
    private $API = 'http://api.t.sina.com.cn/short_url/shorten.json';

    /**
     * 新浪API Key
     *
     * @var string
     */
    private $API_KEY = '';

    /**
     * 初始化
     *
     * @author fdipzone
     * @DateTime 2023-03-22 22:06:36
     *
     * @param array $config 生成器配置
     * @return void
     */
    public function __construct(array $config){
        if(isset($config['api_key'])){
            $this->API_KEY = $config['api_key'];
        }else{
            throw new \Exception('api key is empty');
        }
    }

    /**
     * 生成短链接
     *
     * @author fdipzone
     * @DateTime 2023-03-22 22:02:16
     *
     * @param array $urls
     * @return array
     */
    public function generate(array $urls):array{

        if(!$urls){
            throw new \Exception('urls is empty');
        }

        // 拼接urls参数请求格式
        $url_param = array_map(function($value){
            return '&url_long='.urlencode($value);
        }, $urls);

        $url_param = implode('', $url_param);

        // 请求url
        $request_url = sprintf($this->API.'?source=%s%s', $this->API_KEY, $url_param);

        $result = array();

        // 执行请求
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $request_url);
        $data = curl_exec($ch);
        if($error=curl_errno($ch)){
            throw new \Exception($error);
        }
        curl_close($ch);

        $result = json_decode($data, true);

        return $result;

    }

}