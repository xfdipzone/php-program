<?php
namespace Thumbnail;

/**
 * 缩略图组件接口
 *
 * @author fdipzone
 * @DateTime 2023-04-10 21:49:16
 *
 */
interface IThumbnail{

    /**
     * 初始化
     *
     * @author fdipzone
     * @DateTime 2023-04-20 16:43:43
     *
     * @param Config $config 缩略图配置
     */
    public function __construct(Config $config);

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
    public function create(string $source, string $thumb):Response;

}