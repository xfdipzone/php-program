<?php
namespace DEQue;

/**
 * 定义双向队列支持的类型
 *
 * @author fdipzone
 * @DateTime 2024-05-31 10:41:28
 *
 */
class Type
{
    // 队列类型：不限制，两端均可入队出队
    const UNRESTRICTED= 1;

    // 队列类型：限制头部只能入队不能出队，尾部可入队出队
    const FRONT_ONLY_IN = 2;

    // 队列类型：限制头部只能出队不能入队，尾部可入队出队
    const FRONT_ONLY_OUT = 3;

    // 队列类型：限制尾部只能入队不能出队，头部可入队出队
    const REAR_ONLY_IN = 4;

    // 队列类型：限制尾部只能出队不能入队，头部可入队出队
    const REAR_ONLY_OUT = 5;

    // 队列类型：头部尾部均可入队出队，限制元素只能在入队端出队
    const SAME_IN_OUT = 6;

    /**
     * 判断队列类型是否有效
     *
     * @author fdipzone
     * @DateTime 2024-05-31 10:44:21
     *
     * @param int $type 队列类型
     * @return boolean
     */
    public static function check(int $type):bool
    {
        $types = [
            self::UNRESTRICTED,
            self::FRONT_ONLY_IN,
            self::FRONT_ONLY_OUT,
            self::REAR_ONLY_IN,
            self::REAR_ONLY_OUT,
            self::SAME_IN_OUT
        ];

        if(in_array($type, $types))
        {
            return true;
        }

        return false;
    }
}