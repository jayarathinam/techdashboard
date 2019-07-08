<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Regtype extends Model
{
    protected $table = 'registration_type';

    public function registrations(){
        return $this->hasMany('App\Registration','regtype_id');
    }
}
