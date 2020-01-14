<?php

namespace App\Http\Controllers\Weixin;

use App\Http\Controllers\Controller;
use App\Model\News;
use App\Tools\Curl;
use Illuminate\Http\Request;
use App\Tools\Wechat;
use App\Model\Wxber;
use App\Model\Guanzhu;
use Illuminate\Support\Facades\Redis;
class WeiXinController extends Controller
{
//    private  $student=['刘清源','王振国','老高'];

    public function weixin(Request $request)
    {
//        $echostr=$_GET['echostr'];
//        echo $echostr;die;
//        echo 123;die;
        
        $student = ['刘清源', '王振国', '老高'];

//接入完成之后,微信公众号内用户任何操作  微信服务器=>post形式xml格式  发送到配置的url上
        $xml = file_get_contents("php://input"); //接收原始的xml或json数据流
//写文件里
        file_put_contents("123.txt", "\n" . $xml . "\n", FILE_APPEND);
//方便处理xml=>对象
        $xmlObj = simplexml_load_string($xml);



//如果是关注
        if ($xmlObj->MsgType == 'event' && $xmlObj->Event == 'subscribe') {
            //关注时 获取用户基本信息
            $data=Wechat::getUserInfoByOpenId($xmlObj->FromUserName);
//            $eventKey=$xmlObj->EventKey; //查看标识
            //得到渠道标识
            $g_biao=$data['qr_scene_str'];

            //根据渠道标识,关注人数递增
            \DB::table('guanzhu')->where(['g_biao'=>$g_biao])->increment('g_shu');

            //查询用户信息表
            $cuserInfo = Wxber::where(['openid'=>$xmlObj->FromUserName])->first();
            if($cuserInfo){
                Wxber::where(['openid'=>$xmlObj->FromUserName])->update(['is_del'=>1,'g_biao'=>$g_biao]);
                Wechat::reponseText($xmlObj, '欢迎回来');
            }else{
                Wxber::create([
                    'openid'=>$data['openid'],
                    'nickname'=>$data['nickname'],
                    'city'=>$data['city'],
                    'g_biao'=>$g_biao
                ]);
                $nickname=$data['nickname']; //取到用户昵称
                $sex=$data['sex']==1?'男':'女';
                $msg=$nickname.$sex."只对你有感觉";
//            $msg=$nickname."只对你有感觉";
                //回复文本消息
                Wechat::reponseText($xmlObj, $msg);
            }
        }

        //取消关注
        if ($xmlObj->MsgType == 'event' && $xmlObj->Event == 'unsubscribe') {
            $where = [
                ['openid','=',$xmlObj->FromUserName]
            ];
            Wxber::where($where)->update(['is_del'=>2]);        //用户表基本信息 修改状态
            $res1 = Wxber::where($where)->first()->toArray();   //获取标识
            $wxber = [
                ['g_biao','=',$res1['g_biao']]
            ];
            Guanzhu::Where($wxber)->decrement('g_shu');                //关注人数自减
        }




//如果是用户发送文本消息
        if ($xmlObj->MsgType == 'text') {
            //得到用户发送内容
            $content = trim($xmlObj->Content);
            if ($content == '1') {
                //回复文本消息
                $msg = implode(",", $student);
                Wechat::reponseText($xmlObj, $msg);
            } elseif ($content == '2') {
                //回复文本消息
                shuffle($student);
                $msg = $student[0];
                Wechat::reponseText($xmlObj, $msg);
            } elseif (mb_strpos($content, "天气") !== false) {
                //回复天气
                $city = rtrim($content, "天气");
                if (empty($city)) {
                    $city = "北京";
                }
                $url = "http://api.k780.com/?app=weather.future&weaid=" . $city . "&&appkey=47859&sign=e59b8edd1fd061beb18985bcdc40c8d3&format=json";
                $data = file_get_contents($url);
                $data = json_decode($data, true);
                $msg = "";
                foreach ($data['result'] as $key => $value) {
                    $msg .= $value['days'] . " " . $value['week'] . " " . $value['citynm'] . " " . $value['temperature'] . "\n";
                }
                Wechat::reponseText($xmlObj, $msg);
            } elseif ($content == '最新新闻'){
                $res=News::orderBy('new_id','desc')->first()->toArray();
                $new=$res['new_text'];
//                var_dump($msg);die;
                Wechat::reponseText($xmlObj, $new);
            }elseif(mb_strpos($content,"新闻") !== false){
//                $res=mb_substr($content,2);
                $res=rtrim($content,'新闻');
                $where=[];
                if($res){
                    $where[]=['new_name','like',"%$res%"];
                }
                $newsInfo=News::where($where)->get()->toArray();

                if(!$newsInfo){
                    Wechat::reponseText($xmlObj,'没有相关新闻哦');die;
                }

                $msg = "";
                foreach ($newsInfo as $k=>$v) {
                    News::where('new_id',$v['new_id'])->increment('new_liang');
                    $msg.='标题:'.$v['new_name'].'内容:'.$v['new_text'];
                }
                Wechat::reponseText($xmlObj, $msg);



                $res=News::where()->select()->first();
                $new=$res['new_name'.'new_text'];
                Wechat::reponseText($xmlObj, $new);
                }

            echo "<xml><ToUserName><![CDATA[" . $xmlObj->FromUserName . "]]></ToUserName>
<FromUserName><![CDATA[" . $xmlObj->ToUserName . "]]></FromUserName>
<CreateTime>" . time() . "</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[我多想再见你]]></Content>
</xml>";
            die;
        }
    }



    public function createMenu(){
        //获取
        $access_token=Wechat::getAccessToken();
        //echo date("Y-m-d H:i:s");echo '</br>';
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token=' . $access_token;
        //echo $url;echo '</br>';
        $postData = [
            "button"    => [

                [
                    "type"  => "view",
                    "name"  => "签到",
                    "url"   => "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx0079197aeab14faf&redirect_uri=https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx0079197aeab14faf&redirect_uri=http%3A%2F%2F1905liuqingyuan.comcto.com%2Fweixin%2Fauth&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect"
                ],
            ]
        ];
//        Curl::Post($url,$menu);
        $postData=json_encode($postData,JSON_UNESCAPED_UNICODE);
        //返回地址
        $res=Curl::post($url,$postData);
        json_decode($res,true);
    }


    public function test(){
        $appid=env('WX_APPID');
        $redirect_uri=urlencode(env('WX_AUTH_REDIRECT_URI'));
        $url='https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.$redirect_uri.'&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';
        echo $url;
    }


    public function auth(){
        //接收code
        $code=$_GET['code'];
        //换取access_token
        $url='https://api.weixin.qq.com/sns/oauth2/access_token?appid='.env('WX_APPID').'&secret='.env('WX_APPSEC').'&code='.$code.'&grant_type=authorization_code';
        $json_data=file_get_contents($url);
        $arr=json_decode($json_data,true);
        echo '<pre>';print_r($arr);echo '</pre>';


        //获取用户信息
        $url='https://api.weixin.qq.com/sns/userinfo?access_token='.$arr['access_token'].'&openid='.$arr['openid'].'&lang=zh_CN';
        $json_user_info=file_get_contents($url);
        $user_info_arr=json_decode($json_user_info,true);
        echo '<pre>';print_r($user_info_arr);echo '</pre>';



        //实现签到功能 记录用户签到
        $redis_key = 'checkin:'.date('Y-m-d');
        Redis::Zadd($redis_key,time(),$user_info_arr['openid']);  //将openid加入有序集合
        echo $user_info_arr['nickname'] . "签到成功" . "签到时间： ".date("Y-m-d H:i:s");
        echo '<hr>';
        $user_list = Redis::zrange($redis_key,0,-1);
        //echo '<hr>';
        //echo '<pre>';print_r($user_list);echo '</pre>';
        foreach ($user_list as $k=>$v)
        {
            $key = 'h:user_info:'.$v;
            $u = Redis::hGetAll($key);
            if(empty($u)){
                continue;
            }
            //echo '<pre>';print_r($u);echo '</pre>';
            echo " <img src='".$u['headimgurl']."'> ";
        }
    }





}
