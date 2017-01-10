<?php
/**
 * php 计算多个集合的笛卡尔积
 * Date:    2017-01-10
 * Author:  fdipzone
 * Ver:     1.0
 *
 * Func
 * CartesianProduct 计算多个集合的笛卡尔积
 */

/**
 * 计算多个集合的笛卡尔积
 * @param  Array $sets 集合数组
 * @return Array
 */
function CartesianProduct($sets){

    // 保存结果
    $result = array();

    // 循环遍历集合数据
    for($i=0,$count=count($sets); $i<$count-1; $i++){
        
        // 初始化
        if($i==0){
            $result = $sets[$i];
        }

        // 保存临时数据
        $tmp = array();

        // 结果与下一个集合计算笛卡尔积
        foreach($result as $res){
            foreach($sets[$i+1] as $set){
                $tmp[] = $res.$set;
            }
        }

        // 将笛卡尔积写入结果
        $result = $tmp;

    }

    return $result;

}

// 定义集合
$sets = array(
    array('白色','黑色','红色'),
    array('透气','防滑'),
    array('37码','38码','39码'),
    array('男款','女款')
);

$result = CartesianProduct($sets);
print_r($result);

?>