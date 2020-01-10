@extends('layouts.admin')

@section('title', '新闻-添加')

@section('content')
    <h3>新闻-添加</h3>
    <form action='{{url("/news/add_do")}}' method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="exampleInputEmail1">新闻标题</label>
            <input type="text" class="form-control" name="new_name">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">新闻内容</label>
            <input type="text" class="form-control" name="new_text">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">新闻作者</label>
            <input type="text" class="form-control" name="new_zuo">
        </div>

        <button type="submit" class="btn btn-default">添加</button>
    </form>
@endsection
