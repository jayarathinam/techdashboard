<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ocm extends Model
{
    protected $table = 'ocm';
    protected $fillable = ['targetorg_id','ocmsubtitle_id','name','designation','profile_image_path','college','department','place','country','priority','user_id'];

    public function ocmsubtitle()
    {
        return $this->belongsTo('App\Ocmsubtitle','ocmsubtitle_id');
    }

    public function targetorg()
    {
        return $this->belongsTo('App\Targetorg','targetorg_id');
    }
}
