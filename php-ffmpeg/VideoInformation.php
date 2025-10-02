<?php
/**
 * php 调用ffmpeg实现获取视频信息类
 *
 * @author fdipzone
 * @DateTime 2023-03-18 21:53:34
 *
 */
class VideoInformation
{
    /**
     * ffmpeg执行文件路径
     *
     * @var string
     */
    private $ffmpeg_file = '';

    /**
     * 初始化，设置ffmpeg执行文件路径
     *
     * @author fdipzone
     * @DateTime 2023-03-18 21:55:07
     *
     * @param string $ffmpeg_file ffmpeg执行文件路径
     */
    public function __construct(string $ffmpeg_file)
    {
        if(!file_exists($ffmpeg_file))
        {
            throw new \Exception('ffmepg file not exists');
        }
        $this->ffmpeg_file = $ffmpeg_file;
    }

    /**
     * 调用ffmpeg获取视频信息
     *
     * @author fdipzone
     * @DateTime 2023-03-18 22:03:40
     *
     * @param string $file 视频文件
     * @return array
     */
    public function getInfo(string $file):array
    {
        ob_start();
        passthru($this->ffmpegCmd($file));
        $video_info = ob_get_contents();
        ob_end_clean();

        // 使用输出缓冲，获取ffmpeg所有输出内容
        $ret = array();

        // Duration: 00:33:42.64, start: 0.000000, bitrate: 152 kb/s
        if (preg_match("/Duration: (.*?), start: (.*?), bitrate: (\d*) kb\/s/", $video_info, $matches))
        {
            $ret['duration'] = $matches[1]; // 视频长度
            $duration = explode(':', $matches[1]);
            $ret['seconds'] = $duration[0]*3600 + $duration[1]*60 + $duration[2]; // 转为秒数
            $ret['start'] = $matches[2]; // 开始时间
            $ret['bitrate'] = $matches[3]; // bitrate 码率 单位kb
        }

        // Stream #0:1: Video: rv20 (RV20 / 0x30325652), yuv420p, 352x288, 117 kb/s, 15 fps, 15 tbr, 1k tbn, 1k tbc
        if(preg_match("/Video: (.*?), (.*?), (.*?)[,\s]/", $video_info, $matches))
        {
            $ret['vcodec'] = $matches[1];     // 编码格式
            $ret['vformat'] = $matches[2];    // 视频格式
            $ret['resolution'] = $matches[3]; // 分辨率
            list($width, $height) = explode('x', $matches[3]);
            $ret['width'] = $width;
            $ret['height'] = $height;
        }

        // Stream #0:0: Audio: cook (cook / 0x6B6F6F63), 22050 Hz, stereo, fltp, 32 kb/s
        if(preg_match("/Audio: (.*), (\d*) Hz/", $video_info, $matches))
        {
            $ret['acodec'] = $matches[1];      // 音频编码
            $ret['asamplerate'] = $matches[2]; // 音频采样频率
        }

        // 计算实际播放时间
        if(isset($ret['seconds']) && isset($ret['start']))
        {
            $ret['play_time'] = $ret['seconds'] + $ret['start']; // 实际播放时间
        }

        // 获取视频文件大小
        $ret['size'] = filesize($file); // 视频文件大小

        // 返回视频基本信息及ffmpeg获取的全部信息
        return array(
            'base_info' => $ret,
            'all_info' => $video_info
        );
    }

    /**
     * 获取ffmpeg执行命令行
     *
     * @author fdipzone
     * @DateTime 2023-03-18 21:56:47
     *
     * @param string $file 视频文件
     * @return string
     */
    private function ffmpegCmd(string $file):string
    {
        return sprintf('%s -i "%s" 2>&1', $this->ffmpeg_file, $file);
    }
}