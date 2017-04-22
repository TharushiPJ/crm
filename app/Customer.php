<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table='customer';
    protected $fillable=['companyName','address','bRegNo','website'];
    protected $primaryKey='id';
    public $timestamp=false;
}
