<?php
namespace FileParser;

/**
 * 文件解析器输出结构
 *
 * @author fdipzone
 * @DateTime 2024-08-31 18:44:04
 *
 */
class Response
{
    /**
     * 状态
     * true: 解析成功
     * false: 解析失败
     *
     * @var bool
     */
    private $status;

    /**
     * 解析后的数据
     *
     * @var array
     */
    private $data;

    /**
     * 初始化
     *
     * @author fdipzone
     * @DateTime 2024-08-31 18:46:17
     *
     * @param boolean $status 状态
     * @param array $data 解析后的数据
     */
    public function __construct(bool $status, array $data=[])
    {
        $this->status = $status;
        $this->data = $data;
    }

    /**
     * 获取状态
     *
     * @author fdipzone
     * @DateTime 2024-08-31 18:47:09
     *
     * @return boolean
     */
    public function status():bool
    {
        return $this->status;
    }

    /**
     * 获取解析后的数据
     *
     * @author fdipzone
     * @DateTime 2024-08-31 18:50:17
     *
     * @return array
     */
    public function data():array
    {
        return $this->data;
    }
}