<?php
define('ROOT_PATH', dirname(__FILE__));
require_once ROOT_PATH.'/vendor/autoload.php';
require_once('config.php');

// verifty v2
$secret = RECAPTCHA_V2_SECRET;
$remote_ip = getIp();
$action = 'login';
$token = isset($_GET['token'])? $_GET['token'] : '';

$config = new \Csrf\Config\GoogleRecaptchaV2Config($secret);
$recaptcha = \Csrf\Factory::make(\Csrf\Type::GOOGLE_RECAPTCHA_V2, $config);
$resp = $recaptcha->verify($token, $action, $remote_ip);

if($resp->success())
{
    // Verified!
    $data = array(
        'success' => true
    );
}
else
{
    $errors = $resp->errors();
    $data = array(
        'success' => false,
        'errors' => $errors
    );
}

header('content-type:application/json;charset=utf8');
echo json_encode($data, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);