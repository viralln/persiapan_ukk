<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DemoController extends Controller
{
    public function demo1(){
        return view('demo1');
    }
    public function hello(){
        return "Hello";
    }
}
