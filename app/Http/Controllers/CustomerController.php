<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Customer;
use Psy\Util\Json;
use Mail;
class CustomerController extends Controller
{
    //
    public function index()
    {


        $customers=Customer::all();
        return view('customer')->with('customers',$customers);


    }
    public function getAllCustomers()
    {
        $customers=Customer::all();
        echo Json::encode($customers);
    }

    public function getCustomer($cid){
        $customer=Customer::where('id','=',$cid)->get();
//        dump($customer);
        echo Json::encode($customer);
    }


    public function insert(Request $request)
    {

        $name = $request->input('companyName');
        $add = $request->input('address');
        $regno = $request->input('bRegNo');
        $web = $request->input('website');

        if (DB::insert('insert into customer (companyName,address,bRegNo,website) values(?,?,?,?)', [$name, $add, $regno, $web])) {
           echo "1";
        }
        else{
            echo "0";
        }

        Mail::send('emails.welcome', ['name' => 'Tharushi'], function($message)
        {
            $message->to('srilanka.jobs@webnatics.biz', 'John Smith')->subject('Welcome!');
        });

    }

    public function update(Request $request,$cid)
    {
       // echo $cid;
        $name = $request->input('companyName');
        $add = $request->input('address');
        $regno = $request->input('bRegNo');
        $web = $request->input('website');

        if (DB::table('customer')
            ->where('id', $cid)
            ->update(['companyName' => $name , 'address' => $add,'bRegNo'=>$regno, 'website'=>$web ])){

            echo "1";
        }
        else{
            echo "0";
        }

    }

    public function deleteCustomer($cid){
        if(DB::table('customer')->where('id', '=', $cid)->delete()){
             echo "1";
         }
        else{
            echo "0";
        }

    }

}

