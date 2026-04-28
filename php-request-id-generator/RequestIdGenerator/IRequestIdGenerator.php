<?php
namespace RequestIdGenerator;

/**
 * 请求 ID 生成器接口
 * 定义请求 ID 生成器必须实现的方法
 *
 * @author fdipzone
 * @DateTime 2026-04-27 12:01:19
 *
 */
interface IRequestIdGenerator
{
    /**
     * 生成唯一请求 ID
     *
     * @author fdipzone
     * @DateTime 2026-04-27 12:02:11
     *
     * @return string
     */
    public function generate():string;
}