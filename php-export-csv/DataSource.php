<?php
// 定义数据源
class DataSource implements \ExportCsv\IExportSource
{
    // 要导出的数据，实际情况会从db读取
    private $db_data = array(
        array('1','梦琪','男'),
        array('2','嘉嘉','女'),
        array('3','雅馨','女'),
        array('4',"慕青\"\"\r\n换行",'男'),
        array('5','子萱','女'),
        array('6','瑞欣','女'),
        array('7','幽雪','女'),
        array('8','佳怡','女'),
        array('9','沛菡','女'),
        array('10','曼文','男')
    );

    /**
     * 需要导出的总记录数
     *
     * @author fdipzone
     * @DateTime 2023-06-04 23:10:06
     *
     * @return int
     */
    public function total():int
    {
        return count($this->db_data);
    }

    /**
     * 导出数据的字段名称集合
     *
     * @author fdipzone
     * @DateTime 2023-06-04 23:10:09
     *
     * @return array
     */
    public function fields():array
    {
        $fields = array('id', 'name', 'gender');
        return $fields;
    }

    /**
     * 获取指定范围（批次）的记录
     *
     * @author fdipzone
     * @DateTime 2023-06-04 23:10:26
     *
     * @param int $offset 偏移量
     * @param int $limit  每批次记录条数
     * @return array
     */
    public function data(int $offset, int $limit):array
    {
        return array_slice($this->db_data, $offset, $limit);
    }
}