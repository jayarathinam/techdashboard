<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quicklink extends Model
{
    protected $table = 'quicklinks';
    protected $fillable = ['targetorg_id','link_label','link','priority'];
}
