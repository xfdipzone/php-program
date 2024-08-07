<?php
/**
 * 时区转换类
 *
 * @author fdipzone
 * @DateTime 2024-07-15 19:25:39
 *
 */
class TimeZoneConversion
{
    /**
     * 日期时间时区转换
     * 将原始日期时间转为指定时区的日期时间
     *
     * 时区格式使用 GMT+0000
     * 日期时间字符串格式参考：https://www.php.net/manual/zh/datetime.formats.php
     * 输出格式化参考：https://www.php.net/manual/zh/datetime.format.php
     *
     * @author fdipzone
     * @DateTime 2024-07-15 19:45:21
     *
     * @param string $ori_datetime 原始日期时间
     * @param string $ori_timezone 原始时区
     * @param string $dest_timezone 目标时区
     * @param string $dest_format 目标日期时间输出格式
     * @return array [datetime=>xxx, timezone=>xxx]
     */
    public static function convert(string $ori_datetime, string $ori_timezone, string $dest_timezone='GMT+0800', string $dest_format='Y-m-d H:i:s'):array
    {
        try
        {
            $dt = new \DateTime($ori_datetime, timezone_open($ori_timezone));
            $dt->setTimezone(timezone_open($dest_timezone));

            return array(
                'datetime' => $dt->format($dest_format),
                'timezone' => 'GMT'.$dt->format('O'),
            );
        }
        catch(\Throwable $e)
        {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * 时间戳时区转换
     * 将时间戳转换为指定时区的日期时间
     *
     * 时区格式使用 GMT+0000
     * 输出格式化参考：https://www.php.net/manual/zh/datetime.format.php
     *
     * @author fdipzone
     * @DateTime 2024-07-16 16:54:19
     *
     * @param int $timestamp 时间戳
     * @param string $timezone 要转换的时区
     * @param string $format 输出格式
     * @return string
     */
    public static function timestampConvert(int $timestamp, string $timezone='GMT+0800', string $format='Y-m-d H:i:s'):string
    {
        try
        {
            $dt = new \DateTime('@'.$timestamp);

            // 设置时区
            $tz = timezone_open($timezone);
            $dt->setTimezone($tz);

            // 输出
            return $dt->format($format);
        }
        catch(\Throwable $e)
        {
            throw new \Exception($e->getMessage());
        }
    }
}