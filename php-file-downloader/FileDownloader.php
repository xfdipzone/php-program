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
    private $download_speed;

    /**
     * 是否开启断点续传
     * 默认开启
     *
     * @var boolean
     */
    private $is_resume;

    /**
     * 初始化
     * 设置每次读取下载文件的长度（字节数）
     *
     * @author fdipzone
     * @DateTime 2023-09-07 18:36:36
     *
     * @param int $download_speed 每次读取下载文件的长度
     */
    public function __construct(int $download_speed=512, bool $is_resume=true)
    {
        if($download_speed<16 || $download_speed>4096)
        {
            throw new \Exception('download speed must between 16kb and 4096kb');
        }

        $this->download_speed = $download_speed;
        $this->is_resume = $is_resume;
    }

    /**
     * 下载文件，支持断点续传
     *
     * @author fdipzone
     * @DateTime 2023-09-08 10:22:45
     *
     * @param string $file 要下载的文件路径
     * @param string $name 下载文件重命名，如果不指定则直接使用下载的文件名称
     * @return void
     */
    public function download(string $file, string $name=''):void
    {
        // 判断文件是否存在
        if(!file_exists($file))
        {
            throw new \Exception(sprintf('%s file not exists', $file));
        }

        // 没有指定重命名，使用下载文件名称代替
        if($name=='')
        {
            $name = basename($file);
        }

        // 打开文件流
        $fp = fopen($file, 'rb');

        // 获取 http range 计算下载位点及剩余下载长度
        $file_size = filesize($file);
        $http_ranges = $this->getHttpRange($file_size);

        // 设置header
        header('cache-control:public');
        header('content-type:application/octet-stream');
        header('content-disposition:attachment; filename='.$name);

        // 开启断点续传
        if($this->is_resume && $http_ranges['start']!=0)
        {
            header('HTTP/1.1 206 Partial Content');
            header('Accept-Ranges:bytes');

            // 剩余长度
            header(sprintf('content-length:%u', $http_ranges['end']-$http_ranges['start']));

            // range信息
            header(sprintf('content-range:bytes %s-%s/%s', $http_ranges['start'], $http_ranges['end'], $file_size));

            // fp指针跳到断点位置
            fseek($fp, sprintf('%u', $http_ranges['start']));
        }
        else
        {
            header('HTTP/1.1 200 OK');
            header('content-length:'.$file_size);
        }

        while(!feof($fp))
        {
            echo fread($fp, round($this->download_speed*1024, 0));
            ob_flush();
            //sleep(1); // 用于测试,减慢下载速度
        }

        // 关闭文件
        if($fp!=null)
        {
            fclose($fp);
        }

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