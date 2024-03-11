<?php
namespace Metric;

/**
 * 定义 Metric Callback 接口
 * 支持回调功能的 Metric 需要实现此接口
 *
 * @author fdipzone
 * @DateTime 2024-03-09 18:41:00
 *
 */
interface IMetricCallback
{
    /**
     * 设置回调方法
     *
     * @author fdipzone
     * @DateTime 2024-03-09 18:36:53
     *
     * @param callable $callback 回调方法
     * @return void
     */
    public function setCallback(callable $callback):void;
}