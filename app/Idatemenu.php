<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Idatemenu extends Model
{
    protected $table = 'idatemenus';
    protected $fillable = ['targetorg_id','idatemenu'];

    public function importantdates()
    {
        return $this->hasMany('App\Importantdate','idatemenus_id');
    }
}
