<?php
namespace HttpRequest;

/**
 * 请求数据接口
 *
 * @author fdipzone
 * @DateTime 2023-06-08 22:58:29
 *
 */
interface IRequestData
{
    /**
     * 返回数据类型
     *
     * @author fdipzone
     * @DateTime 2023-06-08 22:59:47
     *
     * @return string
     */
    public function type():string;
}