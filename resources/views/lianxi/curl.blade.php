<?php
    //发送HTTP请求方式  file_get_contents curl

    //curl
    //概念 ??    发送请求的扩展库
    //
    //如何使用
    //4步骤
    //初始化
//    $ch=curl_init();
//    //设置
//    curl_setopt($ch,option,value);
//    //执行
//    $content=curl_exec($ch);
//    //关闭
//    curl_close($ch);

//上传素材接口
$access_token="29_UTFhOiTYlB-kdnaiSJne5dmrMdvxIbZSAIda_IB3RCQCdYiZxfk-65pg-fYY36-cyoItvljrypa7yN8jwQJ1Q57MGEs5-xaDS5UNow6qwdhJ47cdP05AHFQfryC4BZgE01cAK4PQhXyafvzSENDhACALUK";

$url="https://api.weixin.qq.com/cgi-bin/media/upload?access_token=".$access_token."&type=image";

//发送请求 POST
$img="D:\phpstudy_pro\WWW\uzi.jpg"; //图片路径
$img=new \CURLFile($img);   //curl发送文件的时候=>CURLFile处理
$postData['media']=$img;
$res=curlPost($url,$postData);

var_dump($res);die;

//CURL   GET请求
function curlGet($url){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);   //设置请求地址
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);//返回数据格式
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    $output = curl_exec($curl);
    curl_close($curl);
    return $output;
}
//$url="https://www.baidu.com/";
//$data=curlGet($url);
//    var_dump($data);die;



//CURL   POST请求
function curlPost($url,$postData){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);   //设置请求地址
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);//返回数据格式
    curl_setopt($curl,CURLOPT_POST,1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    $output = curl_exec($curl);
    curl_close($curl);
    return $output;
}
$url="https://cf.qq.com/";
$data=curlGet($url);
var_dump($data);die;
?>