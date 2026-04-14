<?php
namespace FileContentOrganization\Handler;

/**
 * 排序处理
 *
 * @author fdipzone
 * @DateTime 2023-03-24 20:18:40
 *
 */
class Sort implements \FileContentOrganization\IHandler
{
    // 排序顺序（正序）
    const ORDER_ASC = 'asc';

    // 排序顺序（逆序）
    const ORDER_DESC = 'desc';

    // 排序类型（按数字排序）
    const SORT_TYPE_NUMERIC = SORT_NUMERIC;

    // 排序类型（按字符串排序）
    const SORT_TYPE_STRING = SORT_STRING;

    /**
     * 排序顺序
     * 可设置的值：asc/desc
     *
     * @var string
     */
    private $order = self::ORDER_ASC;

    /**
     * 排序类型
     * 可设置的值：常量 SORT_NUMERIC/SORT_STRING
     *
     * @var int
     */
    private $sort_type = self::SORT_TYPE_NUMERIC;

    /**
     * 设置排序顺序
     *
     * @author fdipzone
     * @DateTime 2023-03-24 20:24:46
     *
     * @param string $order 排序顺序
     * @return void
     */
    public function setOrder(string $order):void
    {
        $order = strtolower($order);

        if(!in_array($order, [self::ORDER_ASC, self::ORDER_DESC]))
        {
            throw new \Exception('order must be asc or desc');
        }

        $this->order = $order;
    }

    /**
     * 设置排序类型
     *
     * @author fdipzone
     * @DateTime 2023-03-24 20:25:00
     *
     * @param int $sort_type 排序类型
     * @return void
     */
    public function setSortType(int $sort_type):void
    {
        if(!in_array($sort_type, [self::SORT_TYPE_NUMERIC, self::SORT_TYPE_STRING]))
        {
            throw new \Exception('sort_type must be SORT_NUMERIC or SORT_STRING sorting type types');
        }

        $this->sort_type = $sort_type;
    }

    /**
     * 获取排序顺序
     *
     * @author fdipzone
     * @DateTime 2023-03-24 20:24:46
     *
     * @return string
     */
    public function order():string
    {
        return $this->order;
    }

    /**
     * 获取排序类型
     *
     * @author fdipzone
     * @DateTime 2023-03-24 20:25:00
     *
     * @return int
     */
    public function sortType():int
    {
        return $this->sort_type;
    }

    /**
     * 执行处理
     *
     * @author fdipzone
     * @DateTime 2023-03-24 20:19:22
     *
     * @param string $data 文件内容
     * @return string
     */
    public function handle(string $data):string
    {
        // 将内容按换行符分割为数组
        $rows = explode(PHP_EOL, $data);

        // 排序
        if($this->order() == 'asc')
        {
            sort($rows, $this->sortType());
        }
        else
        {
            rsort($rows, $this->sortType());
        }

        // 数组按换行符合拼为字符串
        return implode(PHP_EOL, $rows);
    }
}