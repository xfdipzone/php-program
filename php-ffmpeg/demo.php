<?php
/**
 * php 调用ffmpeg获取视频信息
 * Date:    2016-12-26
 * Author:  fdipzone
 * Version: 1.0
 *
 * Func
 * getVideoInfo
 */

// 定义ffmpeg路径及命令常量
define('FFMPEG_CMD', '/usr/local/bin/ffmpeg -i "%s" 2>&1');

/**
 * 使用ffmpeg获取视频信息
 * @param  String $file 视频文件
 * @return Array
 */
function getVideoInfo($file){
    ob_start();
    passthru(sprintf(FFMPEG_CMD, $file));
    $video_info = ob_get_contents();
    ob_end_clean();

    // 使用输出缓冲，获取ffmpeg所有输出内容
    $ret = array();

    // Duration: 00:33:42.64, start: 0.000000, bitrate: 152 kb/s
    if (preg_match("/Duration: (.*?), start: (.*?), bitrate: (\d*) kb\/s/", $video_info, $matches)){
        $ret['duration'] = $matches[1]; // 视频长度
        $duration = explode(':', $matches[1]);
        $ret['seconds'] = $duration[0]*3600 + $duration[1]*60 + $duration[2]; // 转为秒数
        $ret['start'] = $matches[2]; // 开始时间
        $ret['bitrate'] = $matches[3]; // bitrate 码率 单位kb
    }

    // Stream #0:1: Video: rv20 (RV20 / 0x30325652), yuv420p, 352x288, 117 kb/s, 15 fps, 15 tbr, 1k tbn, 1k tbc
    if(preg_match("/Video: (.*?), (.*?), (.*?)[,\s]/", $video_info, $matches)){
        $ret['vcodec'] = $matches[1];     // 编码格式
        $ret['vformat'] = $matches[2];    // 视频格式
        $ret['resolution'] = $matches[3]; // 分辨率
        list($width, $height) = explode('x', $matches[3]);
        $ret['width'] = $width;
        $ret['height'] = $height;
    }

    // Stream #0:0: Audio: cook (cook / 0x6B6F6F63), 22050 Hz, stereo, fltp, 32 kb/s
    if(preg_match("/Audio: (.*), (\d*) Hz/", $video_info, $matches)){
        $ret['acodec'] = $matches[1];      // 音频编码
        $ret['asamplerate'] = $matches[2]; // 音频采样频率
    }

    if(isset($ret['seconds']) && isset($ret['start'])){
        $ret['play_time'] = $ret['seconds'] + $ret['start']; // 实际播放时间
    }

    $ret['size'] = filesize($file); // 视频文件大小
    
    return array($ret, $video_info);

}

// 输出视频信息
$video_info = getVideoInfo('myvideo.avi');
print_r($video_info[0]);
?>
