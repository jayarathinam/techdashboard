<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Submenu extends Model
{
    protected $table = 'submenu';
    protected $fillable = ['targetorg_id','menu_id','submenu','submenu_link','priority'];
}
