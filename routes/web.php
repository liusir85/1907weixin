<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('weixin','Weixin\WeiXinController@weixin');

//练习上课
Route::get('/lianxi/curl','Lianxi\LianxiController@curl');
Route::get('/lianxi/jiekou','Lianxi\LianxiController@jiekou');


//考试  新闻表
Route::get('/news/add','News\NewsController@add');
Route::post('/news/add_do','News\NewsController@add_do');
Route::get('/news/show','News\NewsController@show');
Route::get('/news/delete/{id}','News\NewsController@delete');
Route::get('/news/edit/{id}','News\NewsController@edit');//编辑
Route::post('/news/update/{id}','News\NewsController@update');//执行编辑




//首页
Route::get('/admin/index','Admin\IndexController@index');


//登录
Route::get('/admin/login','Admin\LoginController@login');

//素材管理
Route::get('/admin/show','Admin\MediaController@show');
Route::get('/admin/add','Admin\MediaController@add');
Route::post('/admin/add_do','Admin\MediaController@add_do');


//关注
Route::get('/guanzhu/add','Guanzhu\GuanzhuController@add');
Route::post('/guanzhu/add_do','Guanzhu\GuanzhuController@add_do');
Route::get('/guanzhu/show','Guanzhu\GuanzhuController@show');
Route::get('/guanzhu/charts','Guanzhu\GuanzhuController@charts');



Route::get('weixin/menu','Weixin\WeiXinController@createMenu');    //创建菜单
