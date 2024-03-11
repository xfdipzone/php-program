<?php
namespace Metric;

/**
 * 定义 Metric 接口
 *
 * @author fdipzone
 * @DateTime 2024-03-09 18:40:45
 *
 */
interface IMetric
{
    /**
     * 判断条件是否满足继续执行
     *
     * @author fdipzone
     * @DateTime 2024-03-09 18:34:50
     *
     * @return boolean
     */
    public function next():bool;
}