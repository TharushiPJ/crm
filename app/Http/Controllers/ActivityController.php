<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Activity;
use App\Customer;
use DB;
use Psy\Util\Json;

class ActivityController extends Controller
{
    public function index()
    {
        $activities=Activity::all();
        return view('activity',['cus'=>Customer::pluck('companyName','id')])->with('activity',$activities);
    }

    public function insert(Request $request)
    {
        $date = $request->input('date');
//        echo $date;
        $type = $request->input('actType');
//echo $type;
        $outcome = $request->input('outcome');
//        echo $outcome;
        $salesPerson = $request->input('personName');
//        echo $salesPerson;
        $customer = $request->input('customer');
//echo $customer;
        if (DB::insert('insert into activity (`date`,`type`,outcome,salesPerson,customer) values(?,?,?,?,?)', [$date, $type, $outcome, $salesPerson, $customer])) {
            echo "1";
        }
        else{
            echo "0";
        }

    }

    public function update(Request $request,$act_id)
    {

        $date = $request->input('date');
//        echo $date;
        $type = $request->input('actType');
//echo $type;
        $outcome = $request->input('outcome');
//        echo $outcome;
        $salesPerson = $request->input('personName');
//        echo $salesPerson;
        $customer = $request->input('customer');

        if (DB::table('activity')
            ->where('act_id', $act_id)
            ->update(['date' => $date , 'type' => $type,'outcome'=>$outcome, 'salesPerson'=>$salesPerson,'customer'=>$customer])){

            echo "1";

        }
        else{
            echo "0";
        }

    }

    public function getActivity($act_id){
        $activity=Activity::where('act_id','=',$act_id)->get();
        echo Json::encode($activity);
    }


    public function getAllActivities()
    {
        //$activity=Activity::all();

        $activity = DB::table('activity')
            ->join('customer', 'customer.id', '=', 'activity.customer')

            ->select('activity.*', 'customer.companyName')
            ->get();
        echo Json::encode($activity);

    }


    public function deleteActivity($act_id){

        if(DB::table('activity')->where('act_id', '=', $act_id)->delete()){
            echo "1";
        }
        else{
            echo "0";
        }


    }



}
