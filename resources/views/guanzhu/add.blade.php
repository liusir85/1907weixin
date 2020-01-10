@extends('layouts.admin')

@section('title', '新闻-添加')

@section('content')
    <h3>渠道-添加</h3>
    <form action='{{url("/guanzhu/add_do")}}' method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="exampleInputEmail1">渠道名称</label>
            <input type="text" class="form-control" name="g_name">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">渠道标识</label>
            <input type="text" class="form-control" name="g_biao">
        </div>

        <button type="submit" class="btn btn-default">添加</button>
    </form>
@endsection