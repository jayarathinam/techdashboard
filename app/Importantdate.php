<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Importantdate extends Model
{
    protected $table = 'important_dates';
    protected $fillable = ['targetorg_id','idatemenus_id','impdate','priority'];

    public function targetorg()
    {
        return $this->belongsTo('App\Targetorg');
    }

    public function idatemenu()
    {
        return $this->belongsTo('App\Idatemenu','idatemenus_id');
    }
}
