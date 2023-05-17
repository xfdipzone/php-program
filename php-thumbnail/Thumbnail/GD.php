<?php
namespace Thumbnail;

/**
 * 使用GD库实现缩略图生成
 *
 * @author fdipzone
 * @DateTime 2023-04-20 16:01:41
 *
 */
class GD implements IThumbnail{

    /**
     * 缩略图配置
     *
     * @var Config
     */
    private $config;

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
     * 初始化
     *
     * @author fdipzone
     * @DateTime 2023-04-20 16:43:43
     *
     * @param Config $config 缩略图配置
     */
    public function __construct(Config $config){

        // 检查GD库是否已安装
        if(!\Thumbnail\Utils\ImageUtil::checkImageHandlerInstalled(Type::GD)){
            throw new \Exception('GD Lib not installed');
        }

        $this->config = $config;
    }

    /**
     * 创建缩略图
     *
     * @author fdipzone
     * @DateTime 2023-05-15 21:55:16
     *
     * @param string $source 源图片文件
     * @param string $thumb  缩略图文件
     * @return Response
     */
    public function create(string $source, string $thumb):Response{

        try{
            // 检查源图片文件
            if(!file_exists($source)){
                throw new \Exception('source file not exists');
            }

            $this->source = $source;
            $this->thumb = $thumb;

            // 创建缩略图文件路径
            \Thumbnail\Utils\ImageUtil::createDirs($thumb);

            // 创建缩略图
            if($this->config->thumbAdapterType()==\Thumbnail\Config\ThumbAdapterType::FIT){
                $is_create = $this->fit();
                if(!$is_create){
                    throw new \Exception('GD fit thumb fail');
                }
            }elseif($this->config->thumbAdapterType()==\Thumbnail\Config\ThumbAdapterType::CROP){
                $is_create = $this->crop();
                if(!$is_create){
                    throw new \Exception('GD crop thumb fail');
                }
            }else{
                throw new \Exception('thumb adapter type error');
            }
        }catch(\Throwable $e){
            $response = new Response;
            $response->setSuccess(false);
            $response->setErrMsg($e->getMessage());
            $response->setSource($this->source);
            $response->setThumb($this->thumb);
            $response->setConfig($this->config);
            return $response;
        }

        // 创建成功
        $response = new Response;
        $response->setSource($this->source);
        $response->setThumb($this->thumb);
        $response->setConfig($this->config);
        return $response;

    }

    /**
     * 按比例适配图片尺寸
     *
     * @author fdipzone
     * @DateTime 2023-05-15 21:55:16
     *
     * @return boolean
     */
    private function fit():bool{
        // 获取生成的图片尺寸
        $source_info = getimagesize($this->source);
        $o_width = $source_info[0];
        $o_height = $source_info[1];

        list($thumb_width, $thumb_height) = \Thumbnail\Utils\SizeUtil::thumbSize(
            $this->config->thumbAdapterType(),
            $o_width, $o_height,
            $this->config->width(),
            $this->config->height()
        );

        // 原图image对象
        $source_img = \Thumbnail\Utils\ImageUtil::imageCreateFromFile($this->source);

        // 按比例缩略/拉伸图片
        $thumb_img = imagecreatetruecolor($thumb_width, $thumb_height);
        imagecopyresampled($thumb_img, $source_img, 0, 0, 0, 0, $thumb_width, $thumb_height, $o_width, $o_height);

        // 判断是否填充背景
        if($this->config->bgcolor()!=''){
            $bg_img = imagecreatetruecolor($this->config->width(), $this->config->height());
            $rgb = \Thumbnail\Utils\ImageUtil::hexToRGB($this->config->bgcolor());
            $bgcolor =imagecolorallocate($bg_img, $rgb['r'], $rgb['g'], $rgb['b']);
            imagefill($bg_img, 0, 0, $bgcolor);
            imagecopy($bg_img, $thumb_img, (int)(($this->config->width()-$thumb_width)/2), (int)(($this->config->height()-$thumb_height)/2), 0, 0, $thumb_width, $thumb_height);
            $thumb_img = $bg_img;
        }

        // 图片对象生成图片文件
        \Thumbnail\Utils\ImageUtil::imageFile($thumb_img, $this->thumb, $this->config->quality());

        // 清除临时image对象
        if(isset($source_img)){
            imagedestroy($source_img);
        }

        if(isset($thumb_img)){
            imagedestroy($thumb_img);
        }

        // 添加水印
        $this->addWatermark($this->thumb);

        return is_file($this->thumb)? true : false;
    }

    /**
     * 裁剪适配图片尺寸
     *
     * @author fdipzone
     * @DateTime 2023-05-15 21:55:16
     *
     * @return boolean
     */
    private function crop():bool{
        // 获取生成的图片尺寸
        $source_info = getimagesize($this->source);
        $o_width = $source_info[0];
        $o_height = $source_info[1];

        list($thumb_width, $thumb_height) = \Thumbnail\Utils\SizeUtil::thumbSize(
            $this->config->thumbAdapterType(),
            $o_width, $o_height,
            $this->config->width(),
            $this->config->height()
        );

        // 获取截图的偏移量
        list($offset_w, $offset_h) = \Thumbnail\Utils\SizeUtil::cropOffset($this->config->cropPosition(), $thumb_width, $thumb_height, $this->config->width(), $this->config->height());

        // 原图image对象
        $source_img = \Thumbnail\Utils\ImageUtil::imageCreateFromFile($this->source);

        // 按比例缩略/拉伸图片
        $tmp_img = imagecreatetruecolor($thumb_width, $thumb_height);
        imagecopyresampled($tmp_img, $source_img, 0, 0, 0, 0, $thumb_width, $thumb_height, $o_width, $o_height);

        // 裁剪图片
        $thumb_img = imagecreatetruecolor($this->config->width(), $this->config->height());
        imagecopyresampled($thumb_img, $tmp_img, 0, 0, $offset_w, $offset_h, $this->config->width(), $this->config->height(), $this->config->width(), $this->config->height());

        // 图片对象生成图片文件
        \Thumbnail\Utils\ImageUtil::imageFile($thumb_img, $this->thumb, $this->config->quality());

        // 清理临时image对象
        if(isset($source_img)){
            imagedestroy($source_img);
        }

        if(isset($tmp_img)){
            imagedestroy($tmp_img);
        }

        if(isset($thumb_img)){
            imagedestroy($thumb_img);
        }

        // 添加水印
        $this->addWatermark($this->thumb);

        return is_file($this->thumb)? true : false;
    }

    /**
     * 添加图片水印
     * GD库不支持透明度水印,如果必须使用透明水印,请将水印图片做成有透明度
     *
     * 如出现 libpng warning: iCCP: known incorrect sRGB profile 警告
     * 对PNG水印图片执行以下命令即可解决
     * convert $file -strip $file
     *
     * @author fdipzone
     * @DateTime 2023-05-15 21:55:16
     *
     * @param string $image 图片路径
     * @return void
     */
    private function addWatermark(string $image):void{
        // 设置不添加图片水印
        if($this->config->watermark()==''){
            return ;
        }

        // 判断图片是否存在
        if(!file_exists($image)){
            throw new \Exception('image not exists');
        }

        // 判断水印图片是否存在
        if(!file_exists($this->config->watermark())){
            throw new \Exception('watermark not exists');
        }

        // 获取图片与水印图片尺寸
        list($p_width, $p_height) = getimagesize($image);
        list($watermark_width, $watermark_height) = getimagesize($this->config->watermark());

        // 判断水印图片与原图尺寸，水印图片比原图尺寸才添加水印
        if($watermark_width>$p_width || $watermark_height>$p_height){
            throw new \Exception('watermark size is more than image size');
        }

        // 水印图与缩略图对象
        $watermark_img = \Thumbnail\Utils\ImageUtil::imageCreateFromFile($this->config->watermark());
        $thumb_img = \Thumbnail\Utils\ImageUtil::imageCreateFromFile($this->thumb);

        // 计算水印图片摆放坐标
        list($position_x, $position_y) = \Thumbnail\Utils\SizeUtil::watermarkPosition($this->config->watermarkGravity(), $p_width, $p_height, $watermark_width, $watermark_height);

        // 获取水印图片定位偏移
        list($position_offset_x, $position_offset_y) = \Thumbnail\Utils\SizeUtil::parseGeometry($this->config->watermarkGravity(), $this->config->watermarkGeometry());

        $position_x += $position_offset_x;
        $position_y += $position_offset_y;

        imagealphablending($thumb_img, true);
        imagecopy($thumb_img, $watermark_img, $position_x, $position_y, 0, 0, $watermark_width, $watermark_width);

        // 图片对象生成图片文件
        \Thumbnail\Utils\ImageUtil::imageFile($thumb_img, $this->thumb, $this->config->quality());

        // 清除临时image对象
        if(isset($watermark_img)){
            imagedestroy($watermark_img);
        }

        if(isset($thumb_img)){
            imagedestroy($thumb_img);
        }

    }

}