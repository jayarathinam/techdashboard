<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $table = 'registration';

    protected $fillable = ['targetorg_id','regcat_id','regtype_id', 'amount'];
}
