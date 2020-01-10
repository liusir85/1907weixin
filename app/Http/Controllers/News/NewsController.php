<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\News;
use App\Tools\Wechat;
class NewsController extends Controller
{
    //添加
    public function add()
    {
//        echo Wechat::getAccessToken();die;
        return view('news.add');
    }

    public function add_do(Request $request)
    {
        $post=$request->except('_token');
        //接值
        $data = $request->input();
//        //调接口
//        $access_token=Wechat::getAccessToken();
//        $url="https://api.weixin.qq.com/cgi-bin/media/upload?access_token=".$access_token."&type=".$data['media_format'];
//        $filePathObj = new \CURLFile(public_path().'/'.$path);
//        $postData=['media'=>$filePathObj];
//        $res=Curl::Post($url,$postData);
//        $res=json_decode($res,true);
//        $media_id=$res['media_id'];     //微信返回的素材id
        //3.入库
        $news=News::create([
            'new_name' => $data['new_name'],
            'new_text'=>$data['new_text'],
            'new_zuo'=>$data['new_zuo'],
            'new_time'=>time(),
        ]);
        if($news->new_id){
            return redirect('/news/show');
        }

    }


    //展示
    public function show(){
        //分页
        $pageSize=config('app.pageSize');
        //搜索
        $word=request()->word;
        $where=[];
        if($word){
            $where[]=['new_name','like',"%$word%"];
        }
        $new_zuo=request()->new_zuo;
        if($new_zuo){
            $where[]=['new_zuo','like',"%$new_zuo%"];
        }


        $data=News::where($where)->paginate(2);
        $query=request()->all();
        return view('news.show',[
            'data'=>$data,'query'=>$query
        ]);
    }


    //删除
    public function delete($primaryKey)
    {

        if(!$primaryKey){
            abort(404);
        };
        $res=News::destroy($primaryKey);
        if($res){
            return redirect('/news/show');
        }
    }



    //编辑
    public function edit($primaryKey)
    {
        if(!$primaryKey){
            return;
        }
        $data=News::where('new_id',$primaryKey)->first();
        return view('news.edit',['data'=>$data]);
    }

    //执行编辑
    public function update(Request $request,$primaryKey )
    {
        $post=$request->except('_token');
        News::where('new_id',$primaryKey)->update($post);
        return redirect('/news/show');
    }

}
