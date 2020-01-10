@extends('layouts.admin')

@section('title', '渠道管理-添加')

@section('content')
    <h3>渠道管理-展示</h3>
    <table class="table table-hover table-bordered">
        <tr>
            <td>渠道名称</td>
            <td>渠道标识</td>
            <td>渠道二维码</td>
            <td>管理</td>
        </tr>
        @foreach($data as $k=>$v)
            <tr>
                <td>{{$v['g_name']}}</td>
                <td>{{$v['g_biao']}}</td>
                <td><img src="https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket={{$v['g_ma']}}" width="100"></td>
                <td><a href="">编辑</a></td>
            </tr>
        @endforeach
    </table>
@endsection