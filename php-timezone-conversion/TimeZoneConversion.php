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
     * @param string $dest_format 目标日期时间格式化格式
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
}