<?php
namespace Captcha;

/**
 * ClickCaptcha配置类
 *
 * @author fdipzone
 * @DateTime 2023-08-23 11:57:08
 *
 */
class ClickCaptchaConfig
{
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
     * Captcha图片宽度
     *
     * @var int
     */
    private $width = 500;

    /**
     * Captcha图片高度
     *
     * @var int
     */
    private $height = 200;

    /**
     * Captcha用于混淆的图形数量
     *
     * @var int
     */
    private $graph_num = 5;

    /**
     * Captcha图形尺寸
     *
     * @var int
     */
    private $graph_size = 56;

    /**
     * 初始化，设置唯一标识
     *
     * @author fdipzone
     * @DateTime 2023-08-23 12:16:56
     *
     * @param string $key 唯一标识
     * @param \Captcha\Storage\IStorage $storage Captcha存储对象
     */
    public function __construct(string $key, \Captcha\Storage\IStorage $storage)
    {
        if(empty($key))
        {
            throw new \Exception('key is empty');
        }
        $this->key = $key;
        $this->storage = $storage;
    }

    /**
     * 获取唯一标识
     *
     * @author fdipzone
     * @DateTime 2023-08-23 12:19:38
     *
     * @return string
     */
    public function key():string
    {
        return $this->key;
    }

    /**
     * 获取Captcha存储对象
     *
     * @author fdipzone
     * @DateTime 2023-08-23 12:19:43
     *
     * @return \Captcha\Storage\IStorage
     */
    public function storage():\Captcha\Storage\IStorage
    {
        return $this->storage;
    }

    /**
     * 设置 Captcha 图片宽度
     *
     * @author fdipzone
     * @DateTime 2023-08-23 14:04:17
     *
     * @param int $width Captcha 图片宽度
     * @return void
     */
    public function setWidth(int $width):void
    {
        if($width<1 || $width>1000)
        {
            throw new \Exception('width must be between 1 and 1000');
        }

        $this->width = $width;
    }

    /**
     * 获取 Captcha 图片宽度
     *
     * @author fdipzone
     * @DateTime 2023-08-23 14:04:13
     *
     * @return int
     */
    public function width():int
    {
        return $this->width;
    }

    /**
     * 设置 Captcha 图片高度
     *
     * @author fdipzone
     * @DateTime 2023-08-23 14:07:58
     *
     * @param int $height Captcha 图片高度
     * @return void
     */
    public function setHeight(int $height):void
    {
        if($height<1 || $height>1000)
        {
            throw new \Exception('height must be between 1 and 1000');
        }

        $this->height = $height;
    }

    /**
     * 获取 Captcha 图片高度
     *
     * @author fdipzone
     * @DateTime 2023-08-23 14:09:28
     *
     * @return int
     */
    public function height():int
    {
        return $this->height;
    }

    /**
     * 设置 Captcha 用于混淆的图形数量
     *
     * @author fdipzone
     * @DateTime 2023-08-23 14:16:31
     *
     * @param int $graph_num 混淆的图形数量
     * @return void
     */
    public function setGraphNum(int $graph_num):void
    {
        if($graph_num<1 || $graph_num>20)
        {
            throw new \Exception('graph num must be between 1 and 20');
        }

        $this->graph_num = $graph_num;
    }

    /**
     * 获取 Captcha 用于混淆的图形数量
     *
     * @author fdipzone
     * @DateTime 2023-08-23 14:17:23
     *
     * @return int
     */
    public function graphNum():int
    {
        return $this->graph_num;
    }

    /**
     * 设置 Captcha 图形尺寸
     *
     * @author fdipzone
     * @DateTime 2023-08-23 15:59:36
     *
     * @param int $graph_size 图形尺寸
     * @return void
     */
    public function setGraphSize(int $graph_size):void
    {
        if($graph_size<1 || $graph_size>200)
        {
            throw new \Exception('graph size must be between 1 and 200');
        }

        $this->graph_size = $graph_size;
    }

    /**
     * 获取 Captcha 图形尺寸
     *
     * @author fdipzone
     * @DateTime 2023-08-23 15:59:32
     *
     * @return int
     */
    public function graphSize():int
    {
        return $this->graph_size;
    }
}