<?php
/**
 * double-ended-queue 双向队列
 * 基于数组存储，支持入队出队方向限制
 *
 * @author fdipzone
 * @DateTime 2024-05-30 18:13:17
 *
 */
class DEQue
{
    // 队列类型：不限制，两端均可入队出队
    const TYPE_UNRESTRICTED= 1;

    // 队列类型：限制头部只能入队不能出队，尾部可入队出队
    const TYPE_FRONT_ONLY_IN = 2;

    // 队列类型：限制头部只能出队不能入队，尾部可入队出队
    const TYPE_FRONT_ONLY_OUT = 3;

    // 队列类型：限制尾部只能入队不能出队，头部可入队出队
    const TYPE_REAR_ONLY_IN = 4;

    // 队列类型：限制尾部只能出队不能入队，头部可入队出队
    const TYPE_REAR_ONLY_OUT = 5;

    // 队列类型：头部尾部均可入队出队，限制元素只能在入队端出队
    const TYPE_SAME_IN_OUT = 6;

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

    public function __construct(int $type, int $maxLength=0)
    {
        $this->type = $type;
        $this->maxLength = $maxLength;
    }


    /**
     * 检查队列类型
     *
     * @author fdipzone
     * @DateTime 2024-05-30 18:30:00
     *
     * @param int $type 队列类型
     * @return boolean
     */
    private function checkType(int $type):bool
    {
        $types = [
            self::TYPE_UNRESTRICTED,
            self::TYPE_FRONT_ONLY_IN,
            self::TYPE_FRONT_ONLY_OUT,
            self::TYPE_REAR_ONLY_IN,
            self::TYPE_REAR_ONLY_OUT,
            self::TYPE_SAME_IN_OUT
        ];

        if(in_array($type, $types))
        {
            return true;
        }

        return false;
    }
}