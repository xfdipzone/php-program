<?php
require 'autoload.php';

// 基于百度地理位置服务
$ak = '您注册的百度 application key';
$config = new \Geocoding\Config\BaiduGeocodingConfig($ak);
$geocoding = new \Geocoding\BaiduGeocoding($config);

// 逆地理编码（返回 POI）
$response = $geocoding->getAddressComponent(113.327782, 23.137202, \Geocoding\ExtensionsPoi::POI);
$error = $response->error();
$err_msg = $response->errMsg();
$status = $response->status();
$formatted_address = $response->formattedAddress();
$business = $response->business();
$address_component = $response->addressComponent();
$poi_set = $response->poiSet();

echo '> 逆地理编码（返回 POI）'.PHP_EOL;

if($error!=0)
{
    printf("error: %d\nerr msg: %s\n\n", $error, $err_msg);
}
elseif($status==0)
{
    printf("status: %d\nformatted address: %s\nbusiness: %s\n", $status, $formatted_address, $business);
    printf("country: %s\nprovince: %s\ncity: %s\ndistrict: %s\ntown: %s\nstreet: %s\nstreet_number: %s\nadcode: %s\ndistance: %s\ndirection: %s\n\n",
    $address_component->country(), $address_component->province(), $address_component->city(), $address_component->district(), $address_component->town(),
    $address_component->street(), $address_component->streetNumber(), $address_component->adcode(), $address_component->distance(), $address_component->direction());

    echo 'POI 集合'.PHP_EOL;
    foreach($poi_set as $poi)
    {
        printf("addr: %s\nname: %s\ntag: %s\nlng: %f\nlat: %f\ndirection: %s\ndistance: %s\n\n",
        $poi->addr(), $poi->name(), $poi->tag(), $poi->point()['lng'], $poi->point()['lat'], $poi->direction(), $poi->distance());
    }

    echo '原始响应数据'.PHP_EOL;
    echo $response->rawResponse().PHP_EOL.PHP_EOL;
}
else
{
    echo $response->rawResponse().PHP_EOL.PHP_EOL;
}

// 逆地理编码（不返回 POI）
$response = $geocoding->getAddressComponent(113.327782, 23.137202, \Geocoding\ExtensionsPoi::NO_POI);
$error = $response->error();
$err_msg = $response->errMsg();
$status = $response->status();
$formatted_address = $response->formattedAddress();
$business = $response->business();
$address_component = $response->addressComponent();

echo '> 逆地理编码（不返回 POI）'.PHP_EOL;

if($error!=0)
{
    printf("error: %d\nerr msg: %s\n\n", $error, $err_msg);
}
elseif($status==0)
{
    printf("status: %d\nformatted address: %s\nbusiness: %s\n", $status, $formatted_address, $business);
    printf("country: %s\nprovince: %s\ncity: %s\ndistrict: %s\ntown: %s\nstreet: %s\nstreet_number: %s\nadcode: %s\ndistance: %s\ndirection: %s\n\n",
    $address_component->country(), $address_component->province(), $address_component->city(), $address_component->district(), $address_component->town(),
    $address_component->street(), $address_component->streetNumber(), $address_component->adcode(), $address_component->distance(), $address_component->direction());

    echo '原始响应数据'.PHP_EOL;
    echo $response->rawResponse().PHP_EOL.PHP_EOL;
}
else
{
    echo $response->rawResponse().PHP_EOL.PHP_EOL;
}

// 地理编码
$response = $geocoding->getLocation('海珠区江南大道中富力海珠城', '广州');
$error = $response->error();
$err_msg = $response->errMsg();
$status = $response->status();
$location = $response->location();
$precise = $response->precise();
$confidence = $response->confidence();
$comprehension = $response->comprehension();
$level = $response->level();

echo '> 地理编码'.PHP_EOL;

if($error!=0)
{
    printf("error: %d\nerr msg: %s\n\n", $error, $err_msg);
}
elseif($status==0)
{
    printf("status: %d\nlng: %f\nlat: %f\nprecise: %d\nconfidence: %d\ncomprehension: %d\nlevel: %s\n\n",
    $status, $location['lng'], $location['lat'], $precise, $confidence, $comprehension, $level);

    echo '原始响应数据'.PHP_EOL;
    echo $response->rawResponse().PHP_EOL;
}
else
{
    echo $response->rawResponse().PHP_EOL.PHP_EOL;
}