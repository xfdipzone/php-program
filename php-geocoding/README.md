# php-geocoding

php 地理编码类

## 介绍

php 实现的地理位置编码服务，支持地址转坐标，及根据坐标获取地址信息，地址周边信息等

基于百度地理编码服务实现，需要注册百度开发者账号，并创建服务端应用，获取 application key

---

## 功能

- 逆地理编码

  根据坐标，获取国家，省份，城市及周边 POI 数据

- 地理编码
  
  根据地址，城市，获取坐标

---

## 演示

```php
require 'autoload.php';

// 基于百度地理位置服务
$ak = '您注册的百度 application key';
$config = new \Geocoding\Config\BaiduGeocodingConfig($ak);
$geocoding = \Geocoding\Factory::make(\Geocoding\Type::BAIDU, $config);

// 逆地理编码（返回 POI）
$response = $geocoding->getAddressComponent(113.327782, 23.137202, \Geocoding\ExtensionsPoi::POI);
print_r($response);

// 逆地理编码（不返回 POI）
$response = $geocoding->getAddressComponent(113.327782, 23.137202, \Geocoding\ExtensionsPoi::NO_POI);
print_r($response);

// 地理编码
$response = $geocoding->getLocation('海珠区江南大道中富力海珠城', '广州');
print_r($response);
```
