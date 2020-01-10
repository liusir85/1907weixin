<?php

namespace App\Http\Controllers\Lianxi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LianxiController extends Controller
{
    public function curl(){
        return view('lianxi.curl');
    }

    public function jiekou(){
        return view('lianxi.jiekou');
    }
}