<?php
namespace DEQue;

/**
 * 定义双向队列入队与出队的响应结构
 *
 * @author fdipzone
 * @DateTime 2024-05-31 10:58:00
 *
 */
class Response
{
    /**
     * 错误码
     * 0 表示没有错误
     *
     * @var int
     */
    private $error;

    /**
     * 错误信息
     *
     * @var string
     */
    private $err_msg;

    /**
     * 队列元素，出队时使用
     *
     * @var \DEQue\Item
     */
    private $item;

    /**
     * 初始化，设置响应内容
     *
     * @author fdipzone
     * @DateTime 2024-05-31 11:09:09
     *
     * @param int $error 错误码
     * @param \DEQue\Item $item 出队的元素
     */
    public function __construct(int $error, \DEQue\Item $item=null)
    {
        $this->error = $error;
        $this->err_msg = \DEQue\ErrCode::msg($error);
        $this->item = $item;
    }

    /**
     * 获取错误码
     *
     * @author fdipzone
     * @DateTime 2024-05-31 11:11:32
     *
     * @return int
     */
    public function error():int
    {
        return $this->error;
    }

    /**
     * 获取错误信息
     *
     * @author fdipzone
     * @DateTime 2024-05-31 11:11:36
     *
     * @return string
     */
    public function errMsg():string
    {
        return $this->err_msg;
    }

    /**
     * 获取出队元素
     *
     * @author fdipzone
     * @DateTime 2024-05-31 11:11:40
     *
     * @return \DEQue\Item|null
     */
    public function item():?\DEQue\Item
    {
        return $this->item;
    }
}