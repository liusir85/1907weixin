<?php
namespace App\Tools;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
class Curl{
    public static function Get($url){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);   //设置请求地址
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);//返回数据格式
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }

    public static function Post($url,$postData){
        $curl = curl_init();
        $data_string = json_encode($postData,JSON_UNESCAPED_UNICODE);     //要发送的数据
        curl_setopt($curl, CURLOPT_URL, $url);   //设置请求地址
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);//返回数据格式
        curl_setopt($curl,CURLOPT_POST,1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        //加入以下设置
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($data_string)));
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }
}