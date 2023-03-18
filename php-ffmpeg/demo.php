<?php
require 'VideoInformation.php';

// 输出视频信息
$ffmpeg_file = '/usr/local/bin/ffmpeg';
$videoInformation = new VideoInformation($ffmpeg_file);
$video_info = $videoInformation->getInfo('myvideo.avi');
print_r($video_info['base_info']);
?>