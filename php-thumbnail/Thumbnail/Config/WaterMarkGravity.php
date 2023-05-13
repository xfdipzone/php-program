<?php
namespace Thumbnail\Config;

/**
 * 水印摆放位置
 *
 * @author fdipzone
 * @DateTime 2023-04-20 21:54:37
 *
 */
class WaterMarkGravity{

    // 西北
    const NORTHWEST = 'NorthWest';

    // 北
    const NORTH = 'North';

    // 东北
    const NORTHEAST = 'NorthEast';

    // 西
    const WEST = 'West';

    // 中
    const CENTER = 'Center';

    // 东
    const EAST = 'East';

    // 西南
    const SOUTHWEST = 'SouthWest';

    // 南
    const SOUTH = 'South';

    // 东南
    const SOUTHEAST = 'SouthEast';

    /**
     * 判断水印摆放位置是否有效
     *
     * @author fdipzone
     * @DateTime 2023-04-20 22:03:52
     *
     * @param string $watermark_gravity 水印摆放位置
     * @return boolean
     */
    public static function valid(string $watermark_gravity):bool{
        switch($watermark_gravity){
            case self::NORTHWEST:
            case self::NORTH:
            case self::NORTHEAST:
            case self::WEST:
            case self::CENTER:
            case self::EAST:
            case self::SOUTHWEST:
            case self::SOUTH:
            case self::SOUTHEAST:
                return true;
        }
        return false;
    }

}