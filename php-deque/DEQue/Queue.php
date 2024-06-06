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
     * 双向队列实例集合
     *
     * @var array
     * @author fdipzone
     * @DateTime 2024-06-06 22:47:44
     *
     */
    private static $instances = [];

    /**
     * 并发锁
     *
     * @var \SyncMutex
     */
    private $mutex;

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
     * 加锁超时时间(ms)
     *
     * @var int
     */
    private $lock_timeout = 100;

    /**
     * 获取双向队列实例
     *
     * @author fdipzone
     * @DateTime 2024-06-06 22:49:41
     *
     * @param string $name 队列名称
     * @param int $type 队列类型
     * @param int $maxLength 队列长度，默认不限制
     * @return \DEQue\Queue
     */
    public static function getInstance(string $name, int $type, int $maxLength=0):\DEQue\Queue
    {
        // 检查队列名称
        if(empty($name))
        {
            throw new \Exception('queue name is empty');
        }

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

        // 判断单例是否存在
        $key = self::instanceKey($name, $type, $maxLength);
        if(isset(self::$instances[$key]))
        {
            return self::$instances[$key];
        }
        else
        {
            $instance = new \DEQue\Queue($name, $type, $maxLength);
            self::$instances[$key] = $instance;
            return $instance;
        }
    }

    /**
     * 创建实例唯一key
     *
     * @author fdipzone
     * @DateTime 2024-06-06 23:26:21
     *
     * @param string $name 队列名称
     * @param int $type 队列类型
     * @param int $maxLength 队列长度，默认不限制
     * @return string
     */
    private static function instanceKey(string $name, int $type, int $maxLength):string
    {
        return sprintf("q:%s:%d:%d", $name, $type, $maxLength);
    }

    /**
     * 初始化
     *
     * @author fdipzone
     * @DateTime 2024-05-31 10:23:17
     *
     * @param string $name 队列名称
     * @param int $type 队列类型
     * @param int $maxLength 队列长度，默认不限制
     */
    private function __construct(string $name, int $type, int $maxLength=0)
    {
        $this->type = $type;
        $this->maxLength = $maxLength;

        // 创建并发锁
        $mutex_key = self::instanceKey($name, $type, $maxLength);
        $this->mutex = new \SyncMutex($mutex_key);
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
        // 加锁
        if(!$this->mutex->lock($this->lock_timeout))
        {
            return new \DEQue\Response(\DEQue\ErrCode::TRYLOCK_TIMEOUT);
        }

        try
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

            // 更新头部插入的元素数量
            if($this->type==\DEQue\Type::SAME_ENDPOINT)
            {
                $this->incrFrontNum(1);
            }

            return new \DEQue\Response(0);
        }
        finally
        {
            // 解锁
            $this->mutex->unlock();
        }
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
        // 加锁
        if(!$this->mutex->lock($this->lock_timeout))
        {
            return new \DEQue\Response(\DEQue\ErrCode::TRYLOCK_TIMEOUT);
        }

        try
        {
            // 检查队列是否为空
            if($this->isEmpty())
            {
                return new \DEQue\Response(\DEQue\ErrCode::EMPTY);
            }

            // 检查类型是否支持头部出队
            if($this->type==\DEQue\Type::FRONT_ONLY_IN)
            {
                return new \DEQue\Response(\DEQue\ErrCode::FRONT_DEQUEUE_RESTRICTED);
            }

            // 检查出队与入队是否同一端
            if($this->type==\DEQue\Type::SAME_ENDPOINT && $this->frontNum==0)
            {
                return new \DEQue\Response(\DEQue\ErrCode::DIFFERENT_ENDPOINT);
            }

            // 从头部获取元素
            $item = array_shift($this->queue);

            // 更新头部插入的元素数量
            if($this->type==\DEQue\Type::SAME_ENDPOINT)
            {
                $this->incrFrontNum(-1);
            }

            return new \DEQue\Response(0, $item);
        }
        finally
        {
            // 解锁
            $this->mutex->unlock();
        }
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
        // 加锁
        if(!$this->mutex->lock($this->lock_timeout))
        {
            return new \DEQue\Response(\DEQue\ErrCode::TRYLOCK_TIMEOUT);
        }

        try
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

            // 更新尾部插入的元素数量
            if($this->type==\DEQue\Type::SAME_ENDPOINT)
            {
                $this->incrRearNum(1);
            }

            return new \DEQue\Response(0);
        }
        finally
        {
            // 解锁
            $this->mutex->unlock();
        }
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
        // 加锁
        if(!$this->mutex->lock($this->lock_timeout))
        {
            return new \DEQue\Response(\DEQue\ErrCode::TRYLOCK_TIMEOUT);
        }

        try
        {
            // 检查队列是否为空
            if($this->isEmpty())
            {
                return new \DEQue\Response(\DEQue\ErrCode::EMPTY);
            }

            // 检查类型是否支持尾部出队
            if($this->type==\DEQue\Type::REAR_ONLY_IN)
            {
                return new \DEQue\Response(\DEQue\ErrCode::REAR_DEQUEUE_RESTRICTED);
            }

            // 检查出队与入队是否同一端
            if($this->type==\DEQue\Type::SAME_ENDPOINT && $this->rearNum==0)
            {
                return new \DEQue\Response(\DEQue\ErrCode::DIFFERENT_ENDPOINT);
            }

            // 从尾部获取元素
            $item = array_pop($this->queue);

            // 更新尾部插入的元素数量
            if($this->type==\DEQue\Type::SAME_ENDPOINT)
            {
                $this->incrRearNum(-1);
            }

            return new \DEQue\Response(0, $item);
        }
        finally
        {
            // 解锁
            $this->mutex->unlock();
        }
    }

    /**
     * 清空队列
     *
     * @author fdipzone
     * @DateTime 2024-06-06 23:10:11
     *
     * @return boolean
     */
    public function clear():bool
    {
        // 加锁
        if(!$this->mutex->lock($this->lock_timeout))
        {
            return false;
        }

        $this->queue = [];
        $this->frontNum = 0;
        $this->rearNum = 0;

        // 解锁
        return $this->mutex->unlock();
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
        if($this->maxLength==0 || $this->maxLength>$this->length())
        {
            return false;
        }

        return true;
    }

    /**
     * 判断队列是否为空
     *
     * @author fdipzone
     * @DateTime 2024-06-01 22:20:56
     *
     * @return boolean
     */
    private function isEmpty():bool
    {
        if($this->length()==0)
        {
            return true;
        }

        return false;
    }

    /**
     * 获取队列长度
     *
     * @author fdipzone
     * @DateTime 2024-06-01 22:18:14
     *
     * @return int
     */
    private function length():int
    {
        return count($this->queue);
    }

    /**
     * 更新头部插入的元素数量
     * 正为自增，负为自减
     *
     * @author fdipzone
     * @DateTime 2024-06-01 22:03:21
     *
     * @param int $num 自增的数量
     * @return void
     */
    private function incrFrontNum(int $num):void
    {
        $this->frontNum = $this->frontNum + $num;
    }

    /**
     * 更新尾部插入的元素数量
     * 正为自增，负为自减
     *
     * @author fdipzone
     * @DateTime 2024-06-01 22:03:24
     *
     * @param int $num 自增的数量
     * @return void
     */
    private function incrRearNum(int $num):void
    {
        $this->rearNum = $this->rearNum + $num;
    }
}