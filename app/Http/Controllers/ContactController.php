<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;
use App\Customer;
use Psy\Util\Json;
use DB;

class ContactController extends Controller
{
    public  function index()
    {
        $contacts=Contact::all();
        //return view('contact')->with('contact',$contacts);
        return view('contact',['cus'=>Customer::pluck('companyName','id')])->with('contact',$contacts);
    }

    public function insert(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $conno = $request->input('contactNo');
        $customer = $request->input('customer');
        echo $customer;
        if (DB::insert('insert into contact (name,email,contactNo,customer) values(?,?,?,?)', [$name, $email, $conno, $customer])) {
           echo "1";
        }
        else{
            echo "0";
        }

    }



    public function update(Request $request,$con_id)
    {

        $name = $request->input('name');
        $email = $request->input('email');
        $conno = $request->input('contactNo');
        $customer = $request->input('customer');

        if (DB::table('contact')
            ->where('con_id', $con_id)
            ->update(['name' => $name , 'email' => $email,'contactNo'=>$conno, 'customer'=>$customer ])){

           echo "1";
        }
        else{
            echo "0";
        }

    }

    public function getContact($con_id){
        $contact=Contact::where('con_id','=',$con_id)->get();
        echo Json::encode($contact);
    }


    public function getAllContacts()
    {

//


//        $contacts=Contact::all();
        $contacts = DB::table('contact')
            ->join('customer', 'customer.id', '=', 'contact.customer')

            ->select('contact.*', 'customer.companyName')
            ->get();
        echo Json::encode($contacts);

    }


    public function deleteContact($con_id){
        if(DB::table('contact')->where('con_id', '=', $con_id)->delete()){
            echo "1";
        }
        else{
            echo "0";
        }

    }



}

