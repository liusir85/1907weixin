@extends('layouts.admin')

@section('title', '新闻-添加')

@section('content')
    <h3>新闻-编辑</h3>
    <form action='{{url("/news/update/".$data->new_id)}}' method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="exampleInputEmail1">新闻标题</label>
            <input type="text" class="form-control" name="new_name" value="{{$data->new_name}}">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">新闻内容</label>
            <input type="text" class="form-control" name="new_text" value="{{$data->new_text}}">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">新闻作者</label>
            <input type="text" class="form-control" name="new_zuo" value="{{$data->new_zuo}}">
        </div>

        <button type="submit" class="btn btn-default">修改</button>
        <button type="reset" class="btn btn-default">清空</button>
    </form>
@endsection
