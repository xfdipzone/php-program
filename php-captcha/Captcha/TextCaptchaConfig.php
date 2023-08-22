<?php
namespace Captcha;

/**
 * TextCaptcha配置类
 *
 * @author fdipzone
 * @DateTime 2023-05-21 18:17:39
 *
 */
class TextCaptchaConfig{

    /**
     * 唯一标识，用于定位生成的验证码
     *
     * @var string
     */
    private $key;

    /**
     * Captcha存储对象
     *
     * @var \Captcha\Storage\IStorage
     */
    private $storage;

    /**
     * Captcha字符尺寸
     * 范围 1 ~ 32
     *
     * @var int
     */
    private $font_size = 13;

    /**
     * Captcha字体
     *
     * @var string
     */
    private $font = '';

    /**
     * Captcha干扰点数量
     * 范围 0 ~ 500
     *
     * @var int
     */
    private $point_num = 100;

    /**
     * Captcha干扰线数量
     * 范围 0 ~ 50
     *
     * @var int
     */
    private $line_num = 2;

    /**
     * 初始化，设置唯一标识
     *
     * @author fdipzone
     * @DateTime 2023-05-21 19:37:30
     *
     * @param string $key 唯一标识
     * @param \Captcha\Storage\IStorage $storage Captcha存储对象
     */
    public function __construct(string $key, \Captcha\Storage\IStorage $storage){
        if(empty($key)){
            throw new \Exception('key is empty');
        }
        $this->key = $key;
        $this->storage = $storage;
    }

    /**
     * 获取唯一标识
     *
     * @author fdipzone
     * @DateTime 2023-05-21 19:38:05
     *
     * @return string
     */
    public function key():string{
        return $this->key;
    }

    /**
     * 获取Captcha存储对象
     *
     * @author fdipzone
     * @DateTime 2023-05-22 16:45:06
     *
     * @return \Captcha\Storage\IStorage
     */
    public function storage():\Captcha\Storage\IStorage{
        return $this->storage;
    }

    /**
     * 设置Captcha字符尺寸
     *
     * @author fdipzone
     * @DateTime 2023-05-21 19:01:00
     *
     * @param int $font_size Captcha字符尺寸
     * @return void
     */
    public function setFontSize(int $font_size):void{
        if($font_size<1 || $font_size>32){
            throw new \Exception('font size must be between 1 and 32');
        }
        $this->font_size = $font_size;
    }

    /**
     * 获取Captcha字符尺寸
     *
     * @author fdipzone
     * @DateTime 2023-05-21 19:08:22
     *
     * @return int
     */
    public function fontSize():int{
        return $this->font_size;
    }

    /**
     * 设置Captcha字体
     *
     * @author fdipzone
     * @DateTime 2023-05-21 19:08:25
     *
     * @param string $font Captcha字体
     * @return void
     */
    public function setFont(string $font):void{
        if(!file_exists($font)){
            throw new \Exception('font not exists');
        }
        $this->font = $font;
    }

    /**
     * 获取Captcha字体
     *
     * @author fdipzone
     * @DateTime 2023-05-21 19:08:30
     *
     * @return string
     */
    public function font():string{
        // 没有设置字体，使用默认字体
        if($this->font==''){
            $this->font = dirname(__FILE__).'/Font/Arial_Rounded_Bold.ttf';
        }
        return $this->font;
    }

    /**
     * 设置Captcha干扰点数量
     *
     * @author fdipzone
     * @DateTime 2023-05-21 19:08:35
     *
     * @param int $point_num Captcha干扰点数量
     * @return void
     */
    public function setPointNum(int $point_num):void{
        if($point_num<0 || $point_num>500){
            throw new \Exception('point_num must be between 0 and 500');
        }
        $this->point_num = $point_num;
    }

    /**
     * 获取Captcha干扰点数量
     *
     * @author fdipzone
     * @DateTime 2023-05-21 19:08:38
     *
     * @return int
     */
    public function pointNum():int{
        return $this->point_num;
    }

    /**
     * 设置Captcha干扰线数量
     *
     * @author fdipzone
     * @DateTime 2023-05-21 19:08:42
     *
     * @param int $line_num Captcha干扰线数量
     * @return void
     */
    public function setLineNum(int $line_num):void{
        if($line_num<0 || $line_num>50){
            throw new \Exception('line_num must be between 0 and 50');
        }
        $this->line_num = $line_num;
    }

    /**
     * 获取Captcha干扰线数量
     *
     * @author fdipzone
     * @DateTime 2023-05-21 19:08:45
     *
     * @return int
     */
    public function lineNum():int{
        return $this->line_num;
    }

}