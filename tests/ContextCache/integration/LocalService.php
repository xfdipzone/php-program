<?php
namespace Tests\ContextCache\integration;

// 定义本地系统
class LocalService
{
    // 调用第三方系统获取时间信息
    public function timeInfo():string
    {
        $thirdPartyClient = new ThirdPartyClient;
        $info = $thirdPartyClient->getInfo();
        return isset($info['time'])? date('Y-m-d H:i:s', $info['time']) : '';
    }

    // 调用第三方系统获取随机数信息
    public function randomNumInfo():int
    {
        $thirdPartyClient = new ThirdPartyClient;
        $info = $thirdPartyClient->getInfo();
        return isset($info['random_num'])? $info['random_num'] : 0;
    }
}
