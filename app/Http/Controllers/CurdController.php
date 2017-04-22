<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Customer;

class CurdController extends Controller
{
    public function insert(){
        Customer::insert(['companyName'=>"tt"]);
        return back();
    }
}
