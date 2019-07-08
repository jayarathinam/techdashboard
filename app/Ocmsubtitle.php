<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ocmsubtitle extends Model
{
    protected $table = 'ocmsubtitle';
    protected $fillable = ['targetorg_id','ocmtitle_id','ocmsubtitle','priority'];

    public function ocmtitle()
    {
        return $this->belongsTo('App\Ocmtitle','ocmtitle_id');
    }

    public function ocms()
    {
        return $this->hasMany('App\Ocm','ocmsubtitle_id');
    }
}
