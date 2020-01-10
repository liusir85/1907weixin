<?php
//
$access_token='29_GunKzHsYFXRihiiceDTr1ROpJqC1f7D9Y5n05ntNZHqwc_jtuso_vD8M-JBRgl4MCoYNDUkd7wOn3iuIwtga8O4-s90GfGQ_qoOcNz6fTmADWYEDVliPniD_FzCUmGCONSuxCUBC5CTnduehBNHeABAJVP';

//地址
$url="https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=".$access_token;

//参数
$postData='{"expire_seconds": 604800, "action_name": "QR_STR_SCENE", "action_info": {"scene": {"scene_str": "uzi"}}}';
//var_dump($postData);die;
//返回地址
$res=curlPost($url,$postData);
//var_dump($res);die;


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
?>