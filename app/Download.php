<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Download extends Model
{
    protected $table = 'downloads';
    protected $fillable = ['targetorg_id', 'filename', 'download_link', 'priority'];

    public function targetorg()
    {
        return $this->belongsTo('App\Targetorg');
    }
}
