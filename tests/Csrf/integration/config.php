<?php
// v2 config
define('RECAPTCHA_V2_SITE_KEY', '请在这里填入 V2 Site Key');
define('RECAPTCHA_V2_SECRET', '请在这里填入 V2 Server Secret');

// v3 config
define('RECAPTCHA_V3_SITE_KEY', '请在这里填入 V3 Site Key');
define('RECAPTCHA_V3_SECRET', '请在这里填入 V3 Server Secret');

// 获取ip
function getIp()
{
    if (!empty($_SERVER["HTTP_CLIENT_IP"]))
    {
        $cip = $_SERVER["HTTP_CLIENT_IP"];
    }
    else if(!empty($_SERVER["HTTP_X_FORWARDED_FOR"]))
    {
        $cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
    }
    else if (!empty($_SERVER["REMOTE_ADDR"]))
    {
        $cip = $_SERVER["REMOTE_ADDR"];
    }
    else
    {
        $cip = "";
    }
    return $cip;
}