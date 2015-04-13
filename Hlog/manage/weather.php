<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if(getenv('HTTP_CLIENT_IP')){
 $onlineip = getenv('HTTP_CLIENT_IP');
}
elseif(getenv('HTTP_X_FORWARDED_FOR')){
 $onlineip = getenv('HTTP_X_FORWARDED_FOR');
}
elseif(getenv('REMOTE_ADDR')){
 $onlineip = getenv('REMOTE_ADDR');
}
else{
 $onlineip = $HTTP_SERVER_VARS['REMOTE_ADDR'];
}
echo $onlineip."<br />";
$url = "http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json&ip=222.178.10.248";
$address = file_get_contents($url);
$address_arr = json_decode($address);
//获取省级代码
$get_province_url = "http://www.weather.com.cn/data/list3/city.xml?level=1";
$all_province_info = file_get_contents($get_province_url);
//切割为数组
$all_province_arr = explode(',', $all_province_info);
$city_code;
foreach ($all_province_arr as $key => $row) {
    $temp = explode('|', $row);
    if ($address_arr->province == $temp[1]) {
        $city_code = $temp[0];
    }
}
//获取城市代码
$all_city_info = file_get_contents("http://www.weather.com.cn/data/list3/city" . $city_code . ".xml?level=2");
$all_city_arr = explode(',', $all_city_info);
foreach ($all_city_arr as $key => $row) {
    $temp = explode('|', $row);
    if ($address_arr->city == $temp[1]) {
        $city_code = $temp[0];
    }
}
//获取区域代码
$all_county_info = file_get_contents("http://www.weather.com.cn/data/list3/city" . $city_code . ".xml?level=2");
$all_county_arr = explode(',', $all_county_info);
$county_arr = explode('|', $all_county_arr[0]);
$city_code = $county_arr[0];
echo $city_code."<br />";
//获取天气
$url = "http://www.weather.com.cn/data/cityinfo/101" . $city_code . ".html";
$weather_info = file_get_contents($url);
$weather_arr = json_decode($weather_info);
echo $weather_arr->weatherinfo->city . "<br /> ";
echo $weather_arr->weatherinfo->weather ."<br />";
echo $weather_arr->weatherinfo->temp1."~".$weather_arr->weatherinfo->temp2;

