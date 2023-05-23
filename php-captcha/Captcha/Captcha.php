<?php
namespace Captcha;

/**
 * Captcha 验证码类
 * 用于生成验证码图片及验证操作
 *
 * Captcha 是 "Completely Automated Public Turing test to tell Computers and Humans Apart" 缩写
 * 一种区分用户是计算机还是人的公共全自动程序
 * 通过验证码向请求的发起方提出问题，能正确回答的即是人类，反之则为机器
 *
 * @author fdipzone
 * @DateTime 2023-05-20 23:24:42
 *
 */
class Captcha{

    /**
     * 根据配置生成Captcha验证码图片流
     *
     * @author fdipzone
     * @DateTime 2023-05-22 16:29:07
     *
     * @param string $key 唯一标识
     * @param int $length 验证码字符串长度
     * @param \Captcha\Config $config Captcha配置
     * @return void
     */
    public static function create(string $key, int $length, \Captcha\Config $config):void{
        try{
            // 创建验证码
            $validate_code = self::randomString($length);

            // 存储验证码
            $config->storage()->save($key, $validate_code);

            // 输出图片流
            self::responseImage($validate_code, $config);

        }catch(\Throwable $e){
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * 验证用户输入的验证码
     *
     * @author fdipzone
     * @DateTime 2023-05-22 16:44:18
     *
     * @param string $key 唯一标识
     * @param string $value 用户输入的验证码
     * @param \Captcha\Storage\IStorage $storage Captcha存储对象
     * @return boolean
     */
    public static function validate(string $key, string $value, \Captcha\Storage\IStorage $storage):bool{
        if(empty($key)){
            throw new \Exception('key is empty');
        }

        if(empty($value)){
            throw new \Exception('value is empty');
        }

        try{
            $validate_code = $storage->get($key);

            // 验证通过，删除存储的验证数据
            if($validate_code==strtoupper($value)){
                $storage->delete($key);
                return true;
            }else{
                return false;
            }

        }catch(\Throwable $e){
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * 获取指定长度的随机字符串
     *
     * @author fdipzone
     * @DateTime 2023-05-22 16:21:50
     *
     * @param int $length 随机字符串长度
     * @return string
     */
    private static function randomString(int $length):string{
        if($length<1){
            throw new \Exception('random string length must be greater than 0');
        }

        // 定义用于生成随机字符串使用的字符
        $chars = 'ABCDEFGHIJKLMNPQRSTUVWXYZ23456789';
        $max = strlen($chars)-1;

        $str = '';
        for($i=0; $i<$length; $i++){
            $str .= $chars[mt_rand(0, $max)];
        }

        return $str;
    }

    /**
     * 输出图片流
     *
     * @author fdipzone
     * @DateTime 2023-05-22 17:16:24
     *
     * @param string $validate_code 验证码
     * @param \Captcha\Config $config Captcha配置
     * @return void
     */
    private static function responseImage(string $validate_code, \Captcha\Config $config):void{
        header('Content-type: image/PNG');

        $length = strlen($validate_code);

        // 验证码图片尺寸
        $p_width = ($config->fontSize() + 12) * $length + 15;
        $p_height = $config->fontSize() + 30;

        // 创建图片对象
        $im = imagecreate($p_width, $p_height);

        // 设置干扰多边形底图
        $values = array(
            mt_rand(0, $p_width), mt_rand(0, $p_height),
            mt_rand(0, $p_width), mt_rand(0, $p_height),
            mt_rand(0, $p_width), mt_rand(0, $p_height),
            mt_rand(0, $p_width), mt_rand(0, $p_height),
            mt_rand(0, $p_width), mt_rand(0, $p_height),
            mt_rand(0, $p_width), mt_rand(0, $p_height),
        );
        imagefilledpolygon($im, $values, 6, imagecolorallocate($im, mt_rand(170, 255), mt_rand(200, 255), mt_rand(210, 255)));

        // 字体
        $font = $config->font();

        // 内容
        for($i=0; $i<$length; $i++){
            // 设置文字颜色
            $color = imagecolorallocate($im, mt_rand(0, 200), mt_rand(0, 200), mt_rand(0, 200));

            // 设置随机x,y坐标，随机角度
            $x = $i / $length * $p_width + mt_rand(5, 10);
            $y = $p_height -15 + mt_rand(-8, 8);
            $angle = mt_rand(-30, 30);
            imagettftext($im, $config->fontSize(), $angle, $x, $y, $color, $font, substr($validate_code, $i, 1));
        }

        // 加入干扰点
        $point_num = $config->pointNum();
        for($i=0; $i<$point_num; $i++){
            $point = imagecolorallocate($im, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
            imagesetpixel($im, mt_rand(0, $p_width), mt_rand(0, $p_height), $point);
        }

        // 加入干扰线
        $line_num = $config->lineNum();
        for($i=0; $i<$line_num; $i++){
            $line = imagecolorallocate($im, mt_rand(50, 255), mt_rand(150, 255), mt_rand(200, 255));
            imageline($im, mt_rand(0, $p_width), mt_rand(0, $p_height), mt_rand(0, $p_width), mt_rand(0, $p_height), $line);
        }

        imagepng($im);
        imagedestroy($im);
    }

}