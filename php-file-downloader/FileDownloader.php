<?php
/**
 * php 下载文件类，支持断点续传下载
 *
 * @author fdipzone
 * @DateTime 2023-09-07 18:25:06
 *
 */
class FileDownloader
{
    /**
     * 每次读取下载文件的长度（字节数）
     * 用于控制下载的速度，默认512kb
     *
     * @var int
     */
    private $download_speed = 512;

    /**
     * 初始化
     * 设置每次读取下载文件的长度（字节数）
     *
     * @author fdipzone
     * @DateTime 2023-09-07 18:36:36
     *
     * @param int $download_speed 每次读取下载文件的长度
     */
    public function __construct(int $download_speed)
    {
        if($download_speed<16 || $download_speed>4096)
        {
            throw new \Exception('download speed must between 16kb and 4096kb');
        }

        $this->download_speed = $download_speed;
    }

    /**
     * 获取 http range 信息
     * 用于根据已下载文件的大小计算剩余下载文件大小（断点续传）
     *
     * @author fdipzone
     * @DateTime 2023-09-07 20:02:30
     *
     * @param int $file_size 下载文件的总大小
     * @return array start:已下载的文件大小 end:下载文件总大小
     */
    private function getHttpRange(int $file_size):array
    {
        $result = array(
            'start' => 0,
            'end' => 0,
        );

        // 获取 http range
        if(isset($_SERVER['HTTP_RANGE']) && !empty($_SERVER['HTTP_RANGE']))
        {
            $range = $_SERVER['HTTP_RANGE'];
            $range = preg_replace('/[\s|,].*/', '', $range);
            $range = explode('-', substr($range, 6));

            if(count($range)<2)
            {
                $range[1] = $file_size;
            }

            $result = array(
                'start' => $range[0],
                'end' => $range[1],
            );
        }

        if(empty($result['start']))
        {
            $result['start'] = 0;
        }

        if(empty($result['end']))
        {
            $result['end'] = $file_size;
        }

        return $result;
    }
}