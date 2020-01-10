<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Tools\Wechat;
use Illuminate\Http\Request;
use App\Tools\Curl;
use App\Model\Media;
class MediaController extends Controller
{
    public function add(){

        //获取access_token
//        $access_token=Wechat::getAccessToken();
//        echo $access_token;die;
        return view('media.add');
    }


    public function add_do(Request $request){
        //接值
        $data=$request->input();
        //文件上传
        $file=$request->file;
        $ext=$file->getClientOriginalExtension();//得到文件后缀名
        $filename=md5(uniqid()).".".$ext;
        $path=$request->file->storeAs('images',$filename);
        //调接口
        $access_token=Wechat::getAccessToken();
        $url="https://api.weixin.qq.com/cgi-bin/media/upload?access_token=".$access_token."&type=".$data['media_format'];
//        $filePath=new \CURLFile($filePath); //curl发送文件需要先通过CURLFlie类处理
        $filePathObj = new \CURLFile(public_path().'/'.$path);
        $postData=['media'=>$filePathObj];
        $res=Curl::Post($url,$postData);
        $res=json_decode($res,true);
            $media_id=$res['media_id'];     //微信返回的素材id
            //3.入库
        Media::create([
                'media_name'=>$data['media_name'],
                'media_format'=>$data['media_format'],
                'media_type'=>$data['media_type'],
                'media_url'=>$path,     //素材上传地址
                'wechat_media_id'=>$media_id,
                'add_time'=>time(),
            ]);


//        //1.laraval框架文件
//        $file=$request->file;
//        if(!$request->hasFile('file')){
//           echo '报错';die;
//        }
//        $filePath=$file->store('images');
//        //2.调用微信上传素材接口 把图片=>微信服务器
//        $access_token=Wechat::getAccessToken();
//        $type="image";
//        $url="https://api.weixin.qq.com/cgi-bin/media/upload?access_token=".$access_token."&type=".$type;
////        $filePath=new \CURLFile($filePath); //curl发送文件需要先通过CURLFlie类处理
//        $filePathObj = new \CURLFile(public_path().'/'.$filePath);
//        $postData=['media'=>$filePathObj];
//        $res=Curl::Post($url,$postData);
//        $res=json_decode($res,true);
//        if(isset($res['media_id'])){
//            $media_id=$res['media_id'];
//            //3.入库
//            Media::create([
//               'media_name'=>$data['media_name'],
//                'media_format'=>$data['media_format'],
//                'media_type'=>$data['media_type'],
//                'media_url'=>$filePath, //素材上传地址
//                'wechat_media_id'=>$media_id,
//                'add_time'=>time(),
//            ]);
//        }

    }


    public function show(){
        $data=Media::get()->toArray();

        return view('media.show',[
            'data'=>$data
        ]);
    }
}