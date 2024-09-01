<?php
/**
 * php 日志类
 *
 * @author fdipzone
 * @DateTime 2023-03-26 17:24:09
 *
 * Description:
 * 1.自定义日志根目录及日志文件名称。
 * 2.使用日期时间格式自定义日志目录。
 * 3.自动创建不存在的日志目录。
 * 4.记录不同分类的日志，例如信息日志，警告日志，错误日志。
 * 5.可自定义日志配置，日志根据标签调用不同的日志配置。
 *
 * Func
 * public  static set_config 设置配置
 * public  static get_logger 获取日志类对象
 * public  info              写入信息日志
 * public  warn              写入警告日志
 * public  error             写入错误日志
 * private add               写入日志
 * private create_log_path   创建日志目录
 * private get_log_file      获取日志文件名称
 */
class LOG{

    /**
     * 日志根目录
     *
     * @var string
     */
    private $_log_path = '.';

    /**
     * 日志文件
     *
     * @var string
     */
    private $_log_file = 'default.log';

    /**
     * 日志自定义目录
     *
     * @var string
     */
    private $_format = 'Y/m/d';

    /**
     * 日志标签
     *
     * @var string
     */
    private $_tag = 'default';

    /**
     * 总配置设定
     *
     * @var array
     */
    private static $_CONFIG = [];

    /**
     * 设置总配置
     *
     * @author fdipzone
     * @DateTime 2023-03-26 17:32:42
     *
     * @param array $config 总配置设定
     * @return void
     */
    public static function set_config(array $config=array()):void{
        self::$_CONFIG = $config;
    }

    /**
     * 根据日志标签获取日志类对象
     * 如日志标签为空，则获取默认日志类对象
     *
     * @author fdipzone
     * @DateTime 2023-03-26 17:26:58
     *
     * @param string $tag 日志标签
     * @return LOG
     */
    public static function get_logger(string $tag='default'):LOG{

        // 根据tag从总配置中获取对应设定，如不存在使用default设定
        $config = isset(self::$_CONFIG[$tag])? self::$_CONFIG[$tag] : (isset(self::$_CONFIG['default'])? self::$_CONFIG['default'] : array());

        // 设置标签
        $config['tag'] = $tag!='' && $tag!='default'? $tag : '-';

        // 返回日志类对象
        return new LOG($config);

    }

    /**
     * 初始化
     *
     * @author fdipzone
     * @DateTime 2023-03-26 17:28:23
     *
     * @param array $config 配置设定
     */
    public function __construct(array $config=array()){

        // 日志根目录
        if(isset($config['log_path'])){
            $this->_log_path = $config['log_path'];
        }

        // 日志文件
        if(isset($config['log_file'])){
            $this->_log_file = $config['log_file'];
        }

        // 日志自定义目录
        if(isset($config['format'])){
            $this->_format = $config['format'];
        }

        // 日志标签
        if(isset($config['tag'])){
            $this->_tag = $config['tag'];
        }

    }

    /**
     * 写入信息日志
     *
     * @author fdipzone
     * @DateTime 2023-03-26 17:33:50
     *
     * @param string $data 日志数据
     * @return boolean
     */
    public function info(string $data):bool{
        return $this->add('INFO', $data);
    }

    /**
     * 写入警告日志
     *
     * @author fdipzone
     * @DateTime 2023-03-26 17:34:26
     *
     * @param string $data 日志数据
     * @return boolean
     */
    public function warn(string $data):bool{
        return $this->add('WARN', $data);
    }

    /**
     * 写入错误日志
     *
     * @author fdipzone
     * @DateTime 2023-03-26 17:34:54
     *
     * @param string $data 日志数据
     * @return boolean
     */
    public function error(string $data):bool{
        return $this->add('ERROR', $data);
    }

    /**
     * 写入日志
     *
     * @author fdipzone
     * @DateTime 2023-03-26 17:35:24
     *
     * @param string $type 日志类型
     * @param string $data 日志数据
     * @return boolean
     */
    private function add(string $type, string $data):bool{

        // 获取日志文件
        $log_file = $this->get_log_file();

        // 创建日志目录
        $is_create = $this->create_log_path(dirname($log_file));

        // 创建日期时间对象
        $dt = new DateTime;

        // 日志内容
        $log_data = sprintf('[%s] %-5s %s %s'.PHP_EOL, $dt->format('Y-m-d H:i:s'), $type, $this->_tag, $data);

        // 写入日志文件
        if($is_create){
            return file_put_contents($log_file, $log_data, FILE_APPEND)? true : false;
        }

        return false;

    }

    /**
     * 创建日志目录
     *
     * @author fdipzone
     * @DateTime 2023-03-26 17:36:11
     *
     * @param string $log_path 日志目录
     * @return boolean
     */
    private function create_log_path(string $log_path):bool{
        if(!is_dir($log_path)){
            return mkdir($log_path, 0777, true)? true : false;
        }
        return true;
    }

    /**
     * 获取日志文件名称
     *
     * @author fdipzone
     * @DateTime 2023-03-26 17:36:39
     *
     * @return string
     */
    private function get_log_file():string{

        // 创建日期时间对象
        $dt = new DateTime;

        // 计算日志目录格式
        return sprintf("%s/%s/%s", $this->_log_path, $dt->format($this->_format), $this->_log_file);

    }

}
?>