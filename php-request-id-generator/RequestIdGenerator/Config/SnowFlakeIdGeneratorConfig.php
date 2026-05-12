<?php
namespace RequestIdGenerator\Config;

/**
 * 雪花算法 ID 生成器配置类
 *
 * @author fdipzone
 * @DateTime 2026-05-12 14:18:16
 *
 */
class SnowFlakeIdGeneratorConfig implements \RequestIdGenerator\Config\IRequestIdGeneratorConfig
{
    /**
     * 数据中心 ID
     *
     * @var int
     */
    private $data_center_id;

    /**
     * 机器 ID
     *
     * @var int
     */
    private $worker_id;

    /**
     * 初始化
     *
     * @author fdipzone
     * @DateTime 2026-05-12 14:22:46
     *
     * @param int $data_center_id 数据中心 ID
     * @param int $worker_id 机器 ID
     */
    public function __construct(int $data_center_id, int $worker_id)
    {
        $this->data_center_id = $data_center_id;
        $this->worker_id = $worker_id;
    }

    /**
     * 获取数据中心 ID
     *
     * @author fdipzone
     * @DateTime 2026-05-12 14:24:02
     *
     * @return int
     */
    public function dataCenterId():int
    {
        return $this->data_center_id;
    }

    /**
     * 获取机器 ID
     *
     * @author fdipzone
     * @DateTime 2026-05-12 14:24:13
     *
     * @return int
     */
    public function workerId():int
    {
        return $this->worker_id;
    }
}