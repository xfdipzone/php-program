<?php
namespace ShortUrlGenerator;

/**
 * 定义短链接生成器接口
 *
 * @author fdipzone
 * @DateTime 2023-03-22 21:37:12
 *
 */
interface IGenerator
{
    /**
     * 初始化生成器类
     *
     * @author fdipzone
     * @DateTime 2023-03-22 22:03:22
     *
     * @param array $config 生成器配置
     * @return void
     */
    public function __construct(array $config);

    /**
     * 生成短链接
     *
     * @author fdipzone
     * @DateTime 2023-03-22 21:41:04
     *
     * @param array $urls 要转换的url集合
     * @return array
     */
    public function generate(array $urls):array;
}