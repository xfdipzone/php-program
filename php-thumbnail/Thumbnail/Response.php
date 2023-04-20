<?php
namespace Thumbnail;

/**
 * 定义缩略图生成类返回结构
 *
 * @author fdipzone
 * @DateTime 2023-04-20 17:17:01
 *
 */
class Response{

    /**
     * 缩略图创建状态
     * true:  创建成功
     * false: 创建失败
     *
     * @var boolean
     */
    private $success = true;

    /**
     * 错误信息
     *
     * @var string
     */
    private $err_msg = '';

    /**
     * 源图片文件
     *
     * @var string
     */
    private $source = '';

    /**
     * 缩略图文件
     *
     * @var string
     */
    private $thumb = '';

    /**
     * 缩略图配置
     *
     * @var Config
     */
    private $config = null;

    /**
     * 设置创建状态
     *
     * @author fdipzone
     * @DateTime 2023-04-20 17:32:14
     *
     * @param boolean $success 创建状态 true/false
     * @return void
     */
    public function setSuccess(bool $success):void{
        $this->success = $success;
    }

    /**
     * 获取创建状态
     *
     * @author fdipzone
     * @DateTime 2023-04-20 17:32:46
     *
     * @return boolean
     */
    public function success():bool{
        return $this->success;
    }

    /**
     * 设置错误信息
     *
     * @author fdipzone
     * @DateTime 2023-04-20 17:34:43
     *
     * @param string $errMsg 错误信息
     * @return void
     */
    public function setErrMsg(string $err_msg):void{
        if(empty($err_msg)){
            throw new \Exception('err msg is empty');
        }
        $this->err_msg = $err_msg;
    }

    /**
     * 获取错误信息
     *
     * @author fdipzone
     * @DateTime 2023-04-20 17:34:57
     *
     * @return string
     */
    public function errMsg():string{
        return $this->err_msg;
    }

    /**
     * 设置源图片文件
     *
     * @author fdipzone
     * @DateTime 2023-04-20 17:31:47
     *
     * @param string $source 源图片文件
     * @return void
     */
    public function setSource(string $source):void{
        if(empty($source)){
            throw new \Exception('source is empty');
        }
        $this->source = $source;
    }

    /**
     * 获取源图片文件
     *
     * @author fdipzone
     * @DateTime 2023-04-20 17:31:31
     *
     * @return string
     */
    public function source():string{
        return $this->source;
    }

    /**
     * 设置缩略图文件
     *
     * @author fdipzone
     * @DateTime 2023-04-20 17:30:08
     *
     * @param string $thumb 缩略图文件
     * @return void
     */
    public function setThumb(string $thumb):void{
        if(empty($thumb)){
            throw new \Exception('thumb is empty');
        }
        $this->thumb = $thumb;
    }

    /**
     * 获取缩略图文件
     *
     * @author fdipzone
     * @DateTime 2023-04-20 17:29:40
     *
     * @return string
     */
    public function thumb():string{
        return $this->thumb;
    }

    /**
     * 设置缩略图配置
     *
     * @author fdipzone
     * @DateTime 2023-04-20 17:29:10
     *
     * @param Config $config 缩略图配置
     * @return void
     */
    public function setConfig(Config $config):void{
        $this->config = $config;
    }

    /**
     * 获取缩略图配置
     *
     * @author fdipzone
     * @DateTime 2023-04-20 17:29:27
     *
     * @return Config
     */
    public function config():?Config{
        return $this->config;
    }

}