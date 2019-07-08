<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Papers extends Model
{
    protected $table = 'abstract';
    protected $fillable = ['site_with_id','title','keywords','abstract','author_name','co_author_name','topic','subtopic','inst_name',
        'attachment','doi_no','name','email','phone','dept','comments','user_id','journal_id','proceeding_id'];
}
