<?php
namespace Captcha;

/**
 * ClickCaptcha 点击型验证码类
 * 用于生成用于点击验证码图片及验证操作
 * 生成图片引导用户在正确的位置点击，将用户点击图片的定位提交，与记录的正确定位范围进行比对验证
 *
 * @author fdipzone
 * @DateTime 2023-08-23 11:57:45
 *
 */
class ClickCaptcha
{
    /**
     * 根据配置生成Captcha验证码图片流
     *
     * @author fdipzone
     * @DateTime 2023-08-23 16:14:30
     *
     * @param string $key 唯一标识
     * @param \Captcha\ClickCaptchaConfig $config Captcha 配置
     * @return void
     */
    public static function create(string $key, \Captcha\ClickCaptchaConfig $config):void
    {
        try
        {
            // 最小圆形区域
            $min_area = $config->graphSize()/2 + 3;

            // 随机生成完整的圆形圆心及半径
            $x = mt_rand($min_area, $config->width()-$min_area);
            $y = mt_rand($min_area, $config->height()-$min_area);
            $r = $config->graphSize()/2;

            // 圆形数据
            $circular = array('x'=>$x, 'y'=>$y, 'r'=>$r);

            // 存储圆形数据
            $config->storage()->save($key, json_encode($circular));

            // 输出图片流
            self::responseImage($circular, $config);
        }
        catch(\Throwable $e)
        {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * 验证用户提交的点击定位数据
     *
     * @author fdipzone
     * @DateTime 2023-08-23 16:13:07
     *
     * @param string $key 唯一标识
     * @param string $value 用户提交的点击定位数据 x坐标,y坐标
     * @param \Captcha\Storage\IStorage $storage Captcha 存储对象
     * @return boolean
     */
    public static function validate(string $key, string $value, \Captcha\Storage\IStorage $storage):bool
    {
        if(empty($key))
        {
            throw new \Exception('key is empty');
        }

        if(empty($value))
        {
            throw new \Exception('value is empty');
        }

        try
        {
            // 用户提交的定位
            list($px, $py) = explode(',', $value);
            if(!is_numeric($px) || !is_numeric($py))
            {
                throw new \Exception('value is error');
            }

            // 获取存储的定位
            $circular_point = $storage->get($key);
            $circular = json_decode($circular_point, true);

            if(is_array($circular) && \Captcha\Utils::pointInArea($px, $py, $circular['x'], $circular['y'], $circular['r']))
            {
                $storage->delete($key);
                return true;
            }
            else
            {
                return false;
            }
        }
        catch(\Throwable $e)
        {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * 输出图片流
     *
     * @author fdipzone
     * @DateTime 2023-08-23 16:43:35
     *
     * @param array $circular 圆形数据 {x=>圆心x坐标, y=>圆心y坐标, r=>圆半径}
     * @param \Captcha\ClickCaptchaConfig $config Captcha 配置
     * @return void
     */
    private static function responseImage(array $circular, \Captcha\ClickCaptchaConfig $config):void
    {
        header('Content-type: image/PNG');

        // 创建图片对象
        $im = imagecreate($config->width(), $config->height());

        // 填充背景（随机颜色）
        imagecolorallocate($im, mt_rand(170, 255), mt_rand(200, 255), mt_rand(210, 255));

        // 最小圆形区域
        $min_area = $config->graphSize()/2 + 3;

        // 创建混淆用的圆形（不闭合）
        for($i=0; $i<$config->graphNum(); $i++)
        {
            $x = mt_rand($min_area, $config->width()-$min_area);
            $y = mt_rand($min_area, $config->height()-$min_area);

            // 画圆弧的开始角度（随机 0 ~ 360）
            $s = mt_rand(0, 360);

            // 画圆弧的结束角度，在开始角度再画指定角度
            $e = $s + 330;

            // 圆形颜色（随机）
            $circular_color = imagecolorallocate($im, mt_rand(0, 200), mt_rand(0, 200), mt_rand(0, 200));
            imagearc($im, $x, $y, $config->graphSize(), $config->graphSize(), $s, $e, $circular_color);
        }

        // 创建正确的圆形（闭合）
        $circular_color = imagecolorallocate($im, mt_rand(0, 200), mt_rand(0, 200), mt_rand(0, 200));
        imagearc($im, $circular['x'], $circular['y'], $config->graphSize(), $config->graphSize(), 0, 360, $circular_color);

        imagepng($im);
        imagedestroy($im);
    }
}