<?php
namespace Thumbnail\Config;

/**
 * 裁剪位置
 *
 * @author fdipzone
 * @DateTime 2023-04-20 22:08:14
 *
 */
class CropPosition{

    // 顶部左侧位置 (Top Left)
    const TL = 'TL';

    // 顶部中央位置 (Top Middle)
    const TM = 'TM';

    // 顶部右侧位置 (Top Right)
    const TR = 'TR';

    // 中间左侧位置 (Middle Left)
    const ML = 'ML';

    // 中心位置 (Middle Middle)
    const MM = 'MM';

    // 中间右侧位置 (Middle Right)
    const MR = 'MR';

    // 底部左侧位置 (Bottom Left)
    const BL = 'BL';

    // 底部中央位置 (Bottom Middle)
    const BM = 'BM';

    // 底部右侧位置 (Bottom Right)
    const BR = 'BR';

    /**
     * 判断裁剪位置是否有效
     *
     * @author fdipzone
     * @DateTime 2023-04-20 22:11:02
     *
     * @param string $crop_position 裁剪位置
     * @return boolean
     */
    public static function valid(string $crop_position):bool{
        switch($crop_position){
            case self::TL:
            case self::TM:
            case self::TR:
            case self::ML:
            case self::MM:
            case self::MR:
            case self::BL:
            case self::BM:
            case self::BR:
                return true;
        }
        return false;
    }
}