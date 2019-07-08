<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Journalpapers extends Model
{
    protected $table = 'journal_papers';
    protected $fillable = ['journal_id','abstract_id','volume','issue'];
}
