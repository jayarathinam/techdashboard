<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Regcategory extends Model
{
    protected $table = 'registration_category';
    protected $fillable = ['targetorg_id', 'regsubmenu_id', 'category'];

    public function registrations()
    {
        return $this->hasMany('App\Registration','regcat_id');
    }
}
