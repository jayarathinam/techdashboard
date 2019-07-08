<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Additionalcontent extends Model
{
    protected $table = 'additional_content';
    protected $fillable = ['targetorg_id', 'titleplace', 'title', 'content','content_type', 'image_path'];
    protected $casts = ['content' => 'array', 'image_path' => 'array'];

    public function targetorg()
    {
        return $this->belongsTo('App\Targetorg');
    }
}
