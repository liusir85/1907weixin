<?php
    namespace App\Tools;
    use Illuminate\Support\Facades\Cache;
    class Wechat{
        const appId="wx0079197aeab14faf";
        const appsecret="e76097268baf9e05fed3c7d35c1430ab";

        //回复文本消息
        public static function reponseText($xmlObj,$msg){
                echo "<xml><ToUserName><![CDATA[".$xmlObj->FromUserName."]]></ToUserName>
    <FromUserName><![CDATA[".$xmlObj->ToUserName."]]></FromUserName>
    <CreateTime>".time()."</CreateTime>
    <MsgType><![CDATA[text]]></MsgType>
    <Content><![CDATA[".$msg."]]></Content>
    </xml>";die;
        }

        //获取微信接口调用凭证 access_token
        public static function getAccessToken(){
//            先判断缓存是否有数据
            $access_token=Cache::get('access_token');
            //有数据之间返回
            if(empty($access_token)){
               //获取access_token(微信接口调用凭证)
                $url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".Self::appId."&secret=".Self::appsecret."";
                $data=file_get_contents($url);
                $data=json_decode($data,true);
                $access_token=$data['access_token'];  //token如何存储2小时？？

                Cache::put('access_token',$access_token,7200); //120分钟
            }
            //没有数据在进去调微信接口获取=>存入缓存
            return $access_token;
        }


        //获取用户信息
        public static function getUserInfoByOpenId($openid){
            $access_token=Self::getAccessToken();
            $url="https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$access_token."&openid=".$openid."&lang=zh_CN";
            $data=file_get_contents($url);
            $data=json_decode($data,true);
            return $data;
        }
    }
?>