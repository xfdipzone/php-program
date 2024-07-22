<?php
/**
 * 版本比对类
 * 版本号与数字相互转换，提升版本号比对效率，节省版本号存储空间
 *
 * @author fdipzone
 * @DateTime 2024-07-22 20:15:51
 *
 */
class Version
{
    /**
     * 将版本号转为数字
     * 例：1.0.0 -> 10000
     *
     * @author fdipzone
     * @DateTime 2024-07-22 20:19:44
     *
     * @param string $version 版本号
     * @return int
     */
    public static function versionToInteger(string $version):int
    {
        if(!self::validate($version))
        {
            throw new \Exception('version validate fail');
        }

        list($major, $minor, $sub) = explode('.', $version);
        $version_num = $major*10000 + $minor*100 + $sub;
        return intval($version_num); 
    }

    /**
     * 将数字转为版本号
     * 例：10000 -> 1.0.0
     *
     * @author fdipzone
     * @DateTime 2024-07-22 20:20:46
     *
     * @param int $version_num 版本数字
     * @return string
     */
    public static function integerToVersion(int $version_num):string
    {
        if(!is_numeric($version_num))
        {
            throw new \Exception('version number validate fail');
        }

        $version = [];
        $version[0] = intval($version_num/10000);
        $version[1] = intval($version_num%10000/100);
        $version[2] = intval($version_num%100);

        return implode('.', $version);
    }

    /**
     * 验证版本号是否正确
     *
     * @author fdipzone
     * @DateTime 2024-07-22 21:48:49
     *
     * @param string $version 版本号
     * @return boolean
     */
    public static function validate(string $version):bool
    {
        $ret = preg_match('/^[0-9]{1,3}\.[0-9]{1,2}\.[0-9]{1,2}$/', $version);
        return $ret? true : false;
    }

    /**
     * 比对两个版本大小
     * 0: 版本一致
     * 1: 版本1比版本2大
     * -1: 版本1比版本2小 
     *
     * @author fdipzone
     * @DateTime 2024-07-22 21:56:00
     *
     * @param string $version1 版本号1
     * @param string $version2 版本号2
     * @return int
     */
    public static function compare(string $version1, string $version2):int
    {
        $version1_number = self::versionToInteger($version1);
        $version2_number = self::versionToInteger($version2);

        if($version1_number==$version2_number)
        {
            return 0;
        }
        elseif($version1_number>$version2_number)
        {
            return 1;
        }
        else
        {
            return -1;
        }
    }
}