<?php
namespace Backoff;

/**
 * 退避算法接口
 * 用途：定义所有退避算法需要实现的功能
 *
 * @author fdipzone
 * @DateTime 2024-05-19 12:02:14
 *
 */
interface IBackoff
{
    /**
     * 退避算法计算，获取计算结果
     * 计算结果包括是否可以重试及重试等待时间间隔
     *
     * @author fdipzone
     * @DateTime 2024-05-19 12:07:53
     *
     * @param \Backoff\Request $request 算法请求结构
     * @return \Backoff\Response
     */
    public function next(\Backoff\Request $request):\Backoff\Response;
}