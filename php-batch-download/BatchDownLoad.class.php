<?php
/**
 * 多进程批量下载文件（使用php curl_multi_exec实现）
 * Date:    2017-07-16
 * Author:  fdipzone
 * Version: 1.0
 *
 * Func
 * public  download 下载处理
 * public  process  多进程下载
 * private to_log   将执行结果写入日志文件
 */
class BatchDownLoad {

    // 下载文件设置
    private $download_config = array();
    
    // 最大开启进程数量
    private $max_process_num = 10;
    
    // 超时秒数
    private $timeout = 10;

    // 日志文件
    private $logfile = null;

    /**
     * 初始化
     * @param  Array  $download_config   下载的文件设置
     * @param  Int    $max_process_num   最大开启的进程数量
     * @param  Int    $timeout           超时秒数
     * @param  String $logfile           日志文件路径
     */
    public function __construct($download_config, $max_process_num=10, $timeout=10, $logfile=''){
        $this->download_config = $download_config;
        $this->max_process_num = $max_process_num;
        $this->timeout = $timeout;

        // 日志文件
        if($logfile){
            $this->logfile = $logfile;
        }else{
            $this->logfile = dirname(__FILE__).'/batch_download_'.date('Ymd').'.log';
        }
    }

    /**
     * 执行下载
     * @result Int
     */
    public function download(){

        // 已处理的数量
        $handle_num = 0;

        // 未处理完成
        while(count($this->download_config)>0){

            // 需要处理的大于最大进程数
            if(count($this->download_config)>$this->max_process_num){
                $process_num = $this->max_process_num;
            // 需要处理的小于最大进程数
            }else{
                $process_num = count($this->download_config);
            }

            // 抽取指定数量进行下载
            $tmp_download_config = array_splice($this->download_config, 0, $process_num);

            // 执行下载
            $result = $this->process($tmp_download_config);

            // 写入日志
            $this->to_log($tmp_download_config, $result);

            // 记录已处理的数量
            $handle_num += count($result);

        }

        return $handle_num;

    }

    /**
     * 多进程下载文件
     * @param  Array $download_config 本次下载的设置
     * @return Array
     */
    public function process($download_config){

        // 文件资源
        $fp = array();

        // curl会话
        $ch = array();

        // 执行结果
        $result = array();

        // 创建curl handle
        $mh = curl_multi_init();

        // 循环设定数量
        foreach($download_config as $k=>$config){
            $ch[$k] = curl_init();
            $fp[$k] = fopen($config[1], 'a');

            curl_setopt($ch[$k], CURLOPT_URL, $config[0]);
            curl_setopt($ch[$k], CURLOPT_FILE, $fp[$k]);
            curl_setopt($ch[$k], CURLOPT_HEADER, 0);
            curl_setopt($ch[$k], CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch[$k], CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.0)');
        
            // 加入处理
            curl_multi_add_handle($mh, $ch[$k]);
        }

        $active = null;

        do{
            $mrc = curl_multi_exec($mh, $active);
        } while($active);

        // 获取数据
        foreach($fp as $k=>$v){
            fwrite($v, curl_multi_getcontent($ch[$k]));
        }

        // 关闭curl handle与文件资源
        foreach($download_config as $k=>$config){
            curl_multi_remove_handle($mh, $ch[$k]);
            fclose($fp[$k]);

            // 检查是否下载成功
            if(file_exists($config[1])){
                $result[$k] = true;
            }else{
                $result[$k] = false;
            }
        }

        curl_multi_close($mh);

        return $result;

    }

    /**
     * 写入日志
     * @param Array $data 下载文件数据
     * @param Array $flag 下载文件状态数据
     */
    private function to_log($data, $flag){
 
        // 临时日志数据
        $tmp_log = '';
 
        foreach($data as $k=>$v){
            $tmp_log .= '['.date('Y-m-d H:i:s').'] url:'.$v[0].' file:'.$v[1].' status:'.$flag[$k].PHP_EOL;
        }
 
        // 创建日志目录
        if(!is_dir(dirname($this->logfile))){
            mkdir(dirname($this->logfile), 0777, true);
        }

        // 写入日志文件
        file_put_contents($this->logfile, $tmp_log, FILE_APPEND);
    }

}