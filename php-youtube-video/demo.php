<?php
require 'YoutubeVideo';

// 用户名称: GOtriphk https://www.youtube.com/user/GOtriphk/videos
$youtube_video = new YoutubeVideo('GOtriphk');
$videos_info = $youtube_video->getVideosInfo();

print_r($videos_info);