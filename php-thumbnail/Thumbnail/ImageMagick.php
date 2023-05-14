<?php
namespace Thumbnail;

/**
 * 使用ImageMagick实现缩略图生成
 *
 * @author fdipzone
 * @DateTime 2023-04-20 16:01:41
 *
 */
class ImageMagick implements IThumbnail{

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

        // 检查ImageMagick是否已安装
        if(!\Thumbnail\Utils\ImageUtil::checkImageHandlerInstalled(Type::IMAGEMAGICK)){
            throw new \Exception('ImageMagick not installed');
        }

        $this->config = $config;
    }

    /**
     * 创建缩略图
     *
     * @author fdipzone
     * @DateTime 2023-04-20 16:31:45
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
                    throw new \Exception('imagemagick fit thumb fail');
                }
            }elseif($this->config->thumbAdapterType()==\Thumbnail\Config\ThumbAdapterType::CROP){
                $is_create = $this->crop();
                if(!$is_create){
                    throw new \Exception('imagemagick crop thumb fail');
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
     * @DateTime 2023-05-13 21:41:09
     *
     * @return boolean
     */
    private function fit():bool{
        // 判断是否填充背景
        if($this->config->bgcolor()!=''){
            $bgcolor = sprintf(" -background '%s' -gravity center -extent '%sx%s' ", $this->config->bgcolor(), $this->config->width(), $this->config->height());
        }else{
            $bgcolor = '';
        }

        // 判断是否要转为RGB
        $source_info = getimagesize($this->source);
        $colorspace = (!isset($source_info['channels']) || $source_info['channels']!=3)? ' -colorspace RGB ' : '';

        // 命令行
        $cmd = sprintf("convert -resize '%sx%s' '%s' %s -quality %s %s '%s'", $this->config->width(), $this->config->height(), $this->source, $bgcolor, $this->config->quality(), $colorspace, $this->thumb);

        // 记录执行的命令
        \Thumbnail\Utils\ImageUtil::debug('', $cmd);

        // 执行命令
        exec($cmd);

        // 添加水印
        $this->addWatermark($this->thumb);

        return is_file($this->thumb)? true : false;
    }

    /**
     * 裁剪适配图片尺寸
     *
     * @author fdipzone
     * @DateTime 2023-05-13 21:42:19
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

        // 判断是否要转为RGB
        $colorspace = (!isset($source_info['channels']) || $source_info['channels']!=3)? ' -colorspace RGB ' : '';

        // 命令行
        $cmd = sprintf("convert -resize '%sx%s' '%s' -quality %s %s -crop %sx%s+%s+%s +repage '%s'", $thumb_width, $thumb_height, $this->source, $this->config->quality(), $colorspace, $this->config->width(), $this->config->height(), $offset_w, $offset_h, $this->thumb);

        // 记录执行的命令
        \Thumbnail\Utils\ImageUtil::debug('', $cmd);

        // 执行命令
        exec($cmd);

        // 添加水印
        $this->addWatermark($this->thumb);

        return is_file($this->thumb)? true : false;
    }

    /**
     * 添加图片水印
     *
     * @author fdipzone
     * @DateTime 2023-05-13 21:44:27
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

        // 添加水印
        $cmd = sprintf("composite -gravity %s -geometry %s -dissolve %s '%s' %s %s", $this->config->watermarkGravity(), $this->config->watermarkGeometry(), $this->config->watermarkOpacity(), $this->config->watermark(), $image, $image);

        // 记录执行的命令
        \Thumbnail\Utils\ImageUtil::debug('', $cmd);

        // 执行命令
        exec($cmd);
    }

}