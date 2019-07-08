<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Regsubmenu extends Model
{
    protected $table = 'registration_submenu';
    protected $fillable = ['targetorg_id','regmenu_id','regsubmenu','created_at','updated_at'];

    public function categories()
    {
        return $this->hasMany('App\Regcategory');
    }
}
