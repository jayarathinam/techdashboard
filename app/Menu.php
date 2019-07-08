<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menu';
    protected $fillable = ['targetorg_id','menu','menu_link','priority'];
    public function submenus()
    {
        return $this->hasMany('App\Submenu','menu_id');
    }
}
