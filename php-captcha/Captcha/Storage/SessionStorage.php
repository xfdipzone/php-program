<?php
namespace Captcha\Storage;

/**
 * 基于Session存储实现Captcha验证码存储类
 *
 * @author fdipzone
 * @DateTime 2023-05-20 23:53:15
 *
 */
class SessionStorage implements IStorage{

    /**
     * 存储配置
     *
     * @var \Captcha\Storage\SessionStorageConfig
     */
    private $config;

    /**
     * 初始化，设置配置类对象
     *
     * @author fdipzone
     * @DateTime 2023-05-21 12:13:56
     *
     * @param IStorageConfig $config 存储配置对象
     */
    public function __construct(IStorageConfig $config){
        if(get_class($config)!='Captcha\Storage\SessionStorageConfig'){
            throw new \Exception('config type error');
        }

        // 判断session是否已开启
        if(session_status()!==PHP_SESSION_ACTIVE){
            throw new \Exception('session not active');
        }

        $this->config = $config;
    }

    /**
     * 保存数据
     *
     * @author fdipzone
     * @DateTime 2023-05-21 11:50:21
     *
     * @param string $key  标识
     * @param string $data 数据
     * @return boolean
     */
    public function save(string $key, string $data):bool{
        $storage_data = $this->dataAssembly($data);
        $_SESSION[$key] = $storage_data;
        return true;
    }

    /**
     * 获取数据
     *
     * @author fdipzone
     * @DateTime 2023-05-21 11:50:41
     *
     * @param string $key 标识
     * @return string
     */
    public function get(string $key):string{
        if(isset($_SESSION[$key])){
            // 拆装数据
            $storage_data = $_SESSION[$key];
            $storage_data_arr = $this->dataDisassembly($storage_data);

            // 判断是否已超时
            if(isset($storage_data_arr['data']) && isset($storage_data_arr['expire']) && time()<$storage_data_arr['expire']){
                return $storage_data_arr['data'];
            }
        }
        return '';
    }

    /**
     * 删除存储的数据
     *
     * @author fdipzone
     * @DateTime 2023-05-21 11:50:54
     *
     * @param string $key 标识
     * @return boolean
     */
    public function delete(string $key):bool{
        if(isset($_SESSION[$key])){
            unset($_SESSION[$key]);
        }
        return true;
    }

    /**
     * 组装数据
     *
     * @author fdipzone
     * @DateTime 2023-05-21 17:27:24
     *
     * @param string $data 原始数据
     * @return string
     */
    private function dataAssembly(string $data):string{
        $storage_data = array(
            'data' => $data,
            'expire' => time() + $this->config->expire()
        );
        return json_encode($storage_data);
    }

    /**
     * 拆装数据
     *
     * @author fdipzone
     * @DateTime 2023-05-21 17:30:15
     *
     * @param string $storage_data 组装的数据
     * @return array {data,expire}
     */
    private function dataDisassembly(string $storage_data){
        try{
            $storage_data_arr = json_decode($storage_data, true);
            return $storage_data_arr;
        }catch(\Throwable $e){
            throw new \Exception($e->getMessage());
        }
    }

}