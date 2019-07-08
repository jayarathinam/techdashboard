<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $table = 'journal';
    protected $fillable = ['title','issn_no','name','website','syear','timeperiod'];
}
