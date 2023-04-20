<?php
namespace Thumbnail\Config;

/**
 * 缩略图适配类型
 *
 * @author fdipzone
 * @DateTime 2023-04-20 21:48:17
 *
 */
class ThumbAdapterType{

    // 按比例适配
    const FIT = 'fit';

    // 裁剪适配
    const CROP = 'crop';

    /**
     * 判断缩略图适配类型是否有效
     *
     * @author fdipzone
     * @DateTime 2023-04-20 21:50:52
     *
     * @param string $type 缩略图适配类型
     * @return boolean
     */
    public static function valid(string $type):bool{
        switch($type){
            case self::FIT:
            case self::CROP:
                return true;
        }
        return false;
    }

}