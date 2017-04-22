<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table='contact';
    protected $fillable=['name','email','contactNo','customer'];
    protected $primaryKey='con_id';
    public $timestamp=false;
}
