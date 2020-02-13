 <?php
/**
 * php 调用新浪API生成短链接 
 * Date:    2017-04-26
 * Author:  fdipzone
 * Ver:     1.0
 *
 * Func
 * getSinaShortUrl 调用新浪接口将长链接转为短链接
 */

/**
 * 调用新浪接口将长链接转为短链接
 * @param  string        $source    申请应用的AppKey
 * @param  array|string  $url_long  长链接，支持多个转换（需要先执行urlencode)
 * @return array
 */
function getSinaShortUrl($source, $url_long){

    // 参数检查
    if(empty($source) || !$url_long){
        return false;
    }

    // 参数处理，字符串转为数组
    if(!is_array($url_long)){
        $url_long = array($url_long);
    }

    // 拼接url_long参数请求格式
    $url_param = array_map(function($value){
        return '&url_long='.urlencode($value);
    }, $url_long);

    $url_param = implode('', $url_param); 

    // 新浪生成短链接接口
    $api = 'http://api.t.sina.com.cn/short_url/shorten.json';

    // 请求url
    $request_url = sprintf($api.'?source=%s%s', $source, $url_param);

    $result = array();

    // 执行请求
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $request_url);
    $data = curl_exec($ch);
    if($error=curl_errno($ch)){
        return false;
    }
    curl_close($ch);

    $result = json_decode($data, true);

    return $result;

}

// AppKey
$source = '您申请的AppKey';

// 单个链接转换
$url_long = 'http://blog.csdn.net/fdipzone';

$data = getSinaShortUrl($source, $url_long);
print_r($data);

// 多个链接转换
$url_long = array(
    'http://blog.csdn.net/fdipzone/article/details/46390573',
    'http://blog.csdn.net/fdipzone/article/details/12180523',
    'http://blog.csdn.net/fdipzone/article/details/9316385'
);

$data = getSinaShortUrl($source, $url_long);
print_r($data);

?>