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

//Route::get('/', function () {
//    return view('welcome');
//});

//Route::get('/', function () {
//    return view('customer');
//});

//Route::get('/', 'UserContoller@index');
//
//Route::get('/hello/{index}', 'UserContoller@test');
Route::get('/','CustomerController@index');
Route::get('/customer','CustomerController@index');

Route::get('/contact','ContactController@index');

Route::get('/activity','ActivityController@index');



Route::post('insertcustomer','CustomerController@insert');
Route::post('updatecustomer/{cid}','CustomerController@update');
Route::post('getcustomer/{cid}','CustomerController@getCustomer');
Route::post('getallcustomer','CustomerController@getAllCustomers');
Route::post('deletecustomer/{cid}','CustomerController@deleteCustomer');


Route::post('insertcontact','ContactController@insert');
Route::post('updatecontact/{con_id}','ContactController@update');
Route::post('getcontact/{con_id}','ContactController@getContact');
Route::post('getallcontacts','ContactController@getAllContacts');
Route::post('deletecontact/{con_id}','ContactController@deleteContact');


Route::post('insertactivity','ActivityController@insert');
Route::post('updateactivity/{act_id}','ActivityController@update');
Route::post('getactivity/{act_id}','ActivityController@getActivity');
Route::post('getallactivities','ActivityController@getAllActivities');
Route::post('deleteactivity/{act_id}','ActivityController@deleteActivity');