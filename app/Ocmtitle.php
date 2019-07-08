<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ocmtitle extends Model
{
    protected $table = 'ocmtitle';
    protected $fillable = ['targetorg_id', 'ocmtitle', 'priority'];

    public function ocmsubtitles()
    {
        return $this->hasMany('App\Ocmsubtitle','ocmtitle_id');
    }
}
