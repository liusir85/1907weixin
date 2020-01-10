<?php

namespace App\Http\Controllers\Guanzhu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Tools\Wechat;
use App\Tools\Curl;
use App\Model\Guanzhu;
class GuanzhuController extends Controller
{
    //添加
    public function add(){
        return view('guanzhu.add');
    }

    //执行添加
    public function add_do(Request $request){
        //接收
        $g_name=$request->input('g_name');
        $g_biao=$request->input('g_biao');
        //获取
        $access_token=Wechat::getAccessToken();
        //地址
        $url="https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=".$access_token;
        //参数
//        $postData='{"expire_seconds": 2592000, "action_name": "QR_STR_SCENE", "action_info": {"scene": {"scene_str": "'.$g_biao.'"}}}';
        $postData=[
          'expire_seconds'  =>2592000,
            'action_name'=>"QR_STR_SCENE",
            'action_info'=>[
                'scene'=>[
                    'scene_str'=>$g_biao
                ],
            ],
        ];
        $postData=json_encode($postData,JSON_UNESCAPED_UNICODE);
        //返回地址
        $res=Curl::post($url,$postData);
        $res=json_decode($res,true);
        $ticket=$res['ticket'];
        //入库
        $guanzhu=Guanzhu::create([
           'g_name'=>$g_name,
            'g_biao'=>$g_biao,
            'g_ma'=>$ticket,
        ]);
        if($guanzhu->g_id){
            return redirect('/guanzhu/show');
        }
    }


    //展示
    public function show(){
        $data=Guanzhu::get()->toArray();
        return view("guanzhu.show",[
           'data'=>$data
        ]);
    }


    public function charts(){
        //数据统计图案
        $data=Guanzhu::get()->toArray();
        $xStr="";
        $yStr="";
        foreach ($data as $key=>$value){
            $xStr.='"'.$value['g_name'].'",';
            $yStr.=$value['g_shu'].',';
        }
        $xStr=rtrim($xStr,",");
        $yStr=rtrim($yStr,",");

        return view("guanzhu.charts",[
            'xStr'=>$xStr,
            'yStr'=>$yStr
        ]);
    }


}