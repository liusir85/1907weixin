@extends('layouts.admin')

@section('title', '素材管理-添加')

@section('content')
    <h3>新闻-展示</h3>
    <form action="">
        <input type="text" name="word" value="{{$query['word']??''}}" placeholder="请输入标题关键字">
        <input type="text" name="new_zuo" value="{{$query['new_zuo']??''}}" placeholder="请输入作者关键字">
        <button>搜索</button>
    </form>
    <table class="table table-hover table-bordered">
        <tr>
            <td>标题</td>
            <td>内容</td>
            <td>作者</td>
            <td>编辑</td>
        </tr>
        @foreach($data as $v)
            <tr>
                <td>{{$v['new_name']}}</td>
                <td>{{$v['new_text']}}</td>
                <td>{{$v['new_zuo']}}</td>
                <td><a href="{{url('news/edit/'.$v->new_id)}}">编辑</a>|
                    <a href="{{url('news/delete/'.$v->new_id)}}">删除</a>
                </td>
            </tr>
        @endforeach
    </table>
    {{--分页--}}
    {{$data ->appends($query)->links()}}
@endsection
