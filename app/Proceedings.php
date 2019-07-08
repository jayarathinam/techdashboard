<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proceedings extends Model
{
    protected $table = 'proceeding';
    protected $fillable = ['conference','title','isbn','cover','place','date'];
}
