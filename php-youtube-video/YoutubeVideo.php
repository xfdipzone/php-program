<?php
/**
 * 获取 Youtube 指定 User 的所有 Video 信息
 * 注意：此类开发时间为 2015年01月08日，现时 Youtube 的版本可能不再支持此方式获取
 * 仅用于归档代码
 *
 * @author fdipzone
 * @DateTime 2015-08-08 14:18:10
 *
 */
class YoutubeVideo
{
    /**
     * youtube user name
     *
     * @var string
     */
    private $user;

    /**
     * 初始化，设置 Youtube user name
     *
     * @author fdipzone
     * @DateTime 2015-08-08 14:20:06
     *
     * @param string $user Youtube user name（注意大小写）
     */
    public function __construct(string $user)
    {
        if(empty($user))
        {
            throw new \Exception('youtube user is empty');
        }

        $this->user = $user;
    }

    /**
     * 获取 Youtube user 所有视频信息
     *
     * @author fdipzone
     * @DateTime 2015-08-08 14:33:13
     *
     * @return array
     */
    public function getVideosInfo():array
    {
        $infos = array();

        // 获取视频数量
        $video_num = $this->getVideosNum();

        // 获取视频信息
        for($i=1; $i<=$video_num; $i++)
        {
            $video_info = $this->getVideoInfo($i);
            array_push($infos, $video_info);
        }

        return $infos;
    }

    /**
     * 获取 Youtube user 所有视频的总数量
     *
     * @author fdipzone
     * @DateTime 2015-08-08 14:34:03
     *
     * @return int
     */
    private function getVideosNum():int
    {
        $videos = simplexml_load_file('http://gdata.youtube.com/feeds/base/users/'.$this->user.'/uploads?max-results=1&start-index=1');
        $video_num = $videos->children('openSearch', true)->totalResults;
        return $video_num;
    }

    /**
     * 根据视频的序号，获取视频的信息
     *
     * @author fdipzone
     * @DateTime 2015-08-08 14:35:57
     *
     * @param int $index Youtube user 视频的序号
     * @return array
     */
    private function getVideoInfo(int $index):array
    {
        // 获取视频id及简介
        $video = simplexml_load_file('http://gdata.youtube.com/feeds/base/users/'.$this->user.'/uploads?max-results=1&start-index='.$index);
        $video_id = str_replace('http://gdata.youtube.com/feeds/base/videos/', '', (string)($video->entry->id));
        $video_content = $this->getVideoIntroduction($video->entry->content);
        $video_publish = strtotime($video->entry->published);

        // 根据视频id获取视频信息
        $content = file_get_contents('http://youtube.com/get_video_info?video_id='.$video_id);
        parse_str($content, $youtube_arr);

        $info = array();

        $info['id'] = $video_id;
        $info['thumb_photo'] = $youtube_arr['thumbnail_url'];       // 缩略图
        $info['middle_photo'] = $youtube_arr['iurlmq'];             // 中图
        $info['big_photo'] = $youtube_arr['iurl'];                  // 大图
        $info['title'] = $youtube_arr['title'];                     // 标题
        $info['content'] = $video_content;                           // 简介
        $info['publish_date'] = $video_publish;                      // 发布时间
        $info['length_seconds'] = $youtube_arr['length_seconds'];   // 视频长度(s)
        $info['view_count'] = $youtube_arr['view_count'];           // 观看次数
        $info['avg_rating'] = $youtube_arr['avg_rating'];           // 平均评分
        $info['embed'] = '//www.youtube.com/embed/'.$video_id;       // Embed

        return $info;
    }

    /**
     * 获取视频的简介
     * 需要在视频文字信息中通过正则获取视频的简介
     *
     * @author fdipzone
     * @DateTime 2015-08-08 14:38:38
     *
     * @param string $content 视频信息
     * @return string
     */
    private function getVideoIntroduction(string $content):string
    {
        preg_match('/<span>(.*?)<\/span>/is', $content, $matches);
        return $this->unescape($matches[1]);
    }

    /**
     * unicode 转中文
     *
     * @author fdipzone
     * @DateTime 2015-08-08 14:24:48
     *
     * @param string $str unicode 字符串
     * @return string
     */
    private function unescape(string $str):string
    {
        $str = rawurldecode($str);
        preg_match_all("/(?:%u.{4})|&#x.{4};|&#\d+;|.+/U", $str, $matches);
        $arr = $matches[0];

        foreach($arr as $k=>$v)
        {
            if(substr($v, 0, 2) == '%u')
            {
                $arr[$k] = iconv('UCS-2BE', 'UTF-8', pack('H4', substr($v, -4)));
            }
            elseif(substr($v, 0, 3) == "&#x")
            {
                $arr[$k] = iconv("UCS-2BE", 'UTF-8', pack('H4', substr($v, 3, -1)));
            }
            elseif(substr($v, 0, 2) == '&#')
            {
                $arr[$k] = iconv('UCS-2BE', 'UTF-8', pack('n', substr($v, 2, -1)));
            }
        }

        return join("", $arr);
    }
}