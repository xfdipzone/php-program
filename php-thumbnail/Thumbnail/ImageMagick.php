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
     * 初始化
     *
     * @author fdipzone
     * @DateTime 2023-04-20 16:43:43
     *
     * @param Config $config 缩略图配置
     */
    public function __construct(Config $config){
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
        $response = new Response;
        return $response;
    }

}