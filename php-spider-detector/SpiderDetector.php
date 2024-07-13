<?php
/**
 * 爬虫机器人检测器
 * 用于检测访问者是否爬虫机器人
 *
 * @author fdipzone
 * @DateTime 2024-07-13 21:51:59
 *
 */
class SpiderDetector
{
    /**
     * 爬虫机器人列表
     *
     * @var array
     * @author fdipzone
     * @DateTime 2024-07-13 21:55:17
     *
     */
    private static $spider_list = [
        'TencentTraveler',
        'Baiduspider+',
        'BaiduGame',
        'Googlebot',
        'msnbot',
        'Sosospider+',
        'Sogou web spider',
        'ia_archiver',
        'Yahoo! Slurp',
        'YoudaoBot',
        'Yahoo Slurp',
        'MSNBot',
        'Java (Often spam bot)',
        'BaiDuSpider',
        'Voila',
        'Yandex bot',
        'BSpider',
        'twiceler',
        'Sogou Spider',
        'Speedy Spider',
        'Google AdSense',
        'Heritrix',
        'Python-urllib',
        'Alexa (IA Archiver)',
        'Ask',
        'Exabot',
        'Custo',
        'OutfoxBot/YodaoBot',
        'yacy',
        'SurveyBot',
        'legs',
        'lwp-trivial',
        'Nutch',
        'StackRambler',
        'The web archive (IA Archiver)',
        'Perl tool',
        'MJ12bot',
        'Netcraft',
        'MSIECrawler',
        'WGet tools',
        'larbin',
        'Fish search',
    ];

    /**
     * 判断访问者是否爬虫机器人
     *
     * @author fdipzone
     * @DateTime 2024-07-13 21:52:45
     *
     * @return boolean
     */
    public static function isSpider():bool
    {
        // 获取访问者 agent
        $agent= strtolower(isset($_SERVER['HTTP_USER_AGENT'])? $_SERVER['HTTP_USER_AGENT'] : '');

        // 判断是否爬虫
        foreach(self::$spider_list as $spider)
        {
            if(strpos($agent, strtolower($spider))!==false)
            {
                return true;
            }
        }

        return false;
    }
}