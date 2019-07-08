<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Registrationmenu extends Model
{
    protected $table = 'registration_menu';

    protected $fillable = ['targetorg_id','regmenu','created_at','updated_at'];

    public function regsmenus()
    {
        return $this->hasMany('App\Regsubmenu','regmenu_id');
    }

    public function regtypes()
    {
        return $this->hasMany('App\Regtype','regmenu_id');
    }
}
