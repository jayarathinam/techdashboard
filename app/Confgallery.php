<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Confgallery extends Model
{
    protected $table = 'galleries';
    protected $fillable = ['targetorg_id','gallery_title','gallery'];
    protected $casts = ['gallery' => 'array'];
}
