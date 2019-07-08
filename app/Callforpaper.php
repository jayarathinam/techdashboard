<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Callforpaper extends Model
{
    protected $table = 'callforpaper';
    protected $fillable = ['targetorg_id','topic','callforpaper'];
    protected $casts = ['callforpaper' => 'array'];


}
