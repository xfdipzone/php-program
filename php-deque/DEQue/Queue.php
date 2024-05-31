<?php
namespace DEQue;

/**
 * double-ended queue 双向队列
 * 基于数组存储，支持入队出队方向限制
 *
 * @author fdipzone
 * @DateTime 2024-05-30 18:13:17
 *
 */
class Queue
{
    /**
     * 队列容器，使用数组存储
     *
     * @var array
     */
    private $queue = [];

    /**
     * 队列最大长度
     *
     * @var int
     */
    private $maxLength = 0;

    /**
     * 队列类型
     *
     * @var int
     */
    private $type;

    /**
     * 从队列头部插入的元素个数
     *
     * @var int
     */
    private $frontNum = 0;

    /**
     * 从队列尾部插入的元素个数
     *
     * @var int
     */
    private $rearNum = 0;

    /**
     * 初始化
     *
     * @author fdipzone
     * @DateTime 2024-05-31 10:23:17
     *
     * @param int $type 队列类型
     * @param int $maxLength 队列长度，默认不限制
     */
    public function __construct(int $type, int $maxLength=0)
    {
        // 检查队列类型
        if(!\DEQue\Type::check($type))
        {
            throw new \Exception('queue type invalid');
        }

        // 检查队列长度
        if($maxLength<0)
        {
            throw new \Exception('queue max length invalid');
        }

        $this->type = $type;
        $this->maxLength = $maxLength;
    }

    /**
     * 从队列头部插入元素（入队）
     *
     * @author fdipzone
     * @DateTime 2024-05-31 17:49:36
     *
     * @param \DEQue\Item $item 队列元素
     * @return \DEQue\Response
     */
    public function pushFront(\DEQue\Item $item):\DEQue\Response
    {
        // 检查队列是否已满
        if($this->isFull())
        {
            return new \DEQue\Response(\DEQue\ErrCode::FULL);
        }

        // 检查类型是否支持头部入队
        if($this->type==\DEQue\Type::FRONT_ONLY_OUT)
        {
            return new \DEQue\Response(\DEQue\ErrCode::FRONT_ENQUEUE_RESTRICTED);
        }

        // 插入元素
        array_unshift($this->queue, $item);

        return new \DEQue\Response(0);
    }

    /**
     * 从队列头部获取元素（出队）
     *
     * @author fdipzone
     * @DateTime 2024-05-31 17:50:21
     *
     * @return \DEQue\Response
     */
    public function popFront():\DEQue\Response
    {
        return new \DEQue\Response(0);
    }

    /**
     * 从队列尾部插入元素（入队）
     *
     * @author fdipzone
     * @DateTime 2024-05-31 17:52:12
     *
     * @param \DEQue\Item $item 队列元素
     * @return \DEQue\Response
     */
    public function pushRear(\DEQue\Item $item):\DEQue\Response
    {
        // 检查队列是否已满
        if($this->isFull())
        {
            return new \DEQue\Response(\DEQue\ErrCode::FULL);
        }

        // 检查类型是否支持尾部入队
        if($this->type==\DEQue\Type::REAR_ONLY_OUT)
        {
            return new \DEQue\Response(\DEQue\ErrCode::REAR_ENQUEUE_RESTRICTED);
        }

        // 插入元素
        array_push($this->queue, $item);

        return new \DEQue\Response(0);
    }

    /**
     * 从队列尾部获取元素（出队）
     *
     * @author fdipzone
     * @DateTime 2024-05-31 17:52:23
     *
     * @return \DEQue\Response
     */
    public function popRear():\DEQue\Response
    {
        return new \DEQue\Response(0);
    }

    /**
     * 判断队列是否已满
     *
     * @author fdipzone
     * @DateTime 2024-05-31 17:56:33
     *
     * @return boolean
     */
    private function isFull():bool
    {
        if($this->maxLength==0 || $this->maxLength>count($this->queue))
        {
            return false;
        }

        return true;
    }

}