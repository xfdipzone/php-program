<?php
namespace DEQue;

/**
 * 定义双向队列元素结构
 *
 * @author fdipzone
 * @DateTime 2024-05-31 10:55:34
 *
 */
class Item
{
    /**
     * 队列元素数据
     *
     * @var string
     */
    private $data = '';

    /**
     * 初始化，设置队列元素数据
     *
     * @author fdipzone
     * @DateTime 2024-05-31 11:01:54
     *
     * @param string $data 队列元素数据
     */
    public function __construct(string $data)
    {
        // 检查队列元素数据
        if(empty($data))
        {
            throw new \Exception('queue item data is empty');
        }

        $this->data = $data;
    }

    /**
     * 获取队列元素数据
     *
     * @author fdipzone
     * @DateTime 2024-05-31 11:04:50
     *
     * @return string
     */
    public function data():string
    {
        return $this->data;
    }
}