<?php
/**
 * php 计算多个集合的笛卡尔积
 *
 * @author fdipzone
 * @DateTime 2023-03-20 19:36:40
 *
 */
class CartesianProduct{

    /**
     * 计算多个集合的笛卡尔积
     *
     * @author fdipzone
     * @DateTime 2023-03-20 19:37:52
     *
     * @param array $sets
     * @return array
     */
    public static function cal(array $sets):array{

        // 保存结果
        $result = array();

        // 循环遍历集合数据
        for($i=0,$count=count($sets); $i<$count; $i++){

            // 初始化，第一个集合，不用做笛卡尔积
            if($i==0){
                $result = $sets[$i];
                continue;
            }

            // 保存临时数据
            $tmp = array();

            // 结果与当前集合计算笛卡尔积
            foreach($result as $res){
                foreach($sets[$i] as $set){
                    $tmp[] = $res.$set;
                }
            }

            // 将笛卡尔积写入结果
            $result = $tmp;

        }

        return $result;

    }

}