<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserContoller extends Controller
{
    public function index(){
        return view('welcome');
    }

    public function test($index){
        $name = [1,2,3,4];
//        return view('hello')->with('name',$name);
        return view('hello',compact('name','index'));
    }

    public function customer(){

        return view('customer');
    }

    public function contact(){

        return view('contact');
    }

    public function activity(){
        return view('activity');
    }
}

