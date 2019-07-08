<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Targetorg extends Model
{
    protected $table = 'target_org';
    protected $fillable = ['name', 'fullname', 'type', 'city', 'country', 'venue', 'sdate', 'edate'];

    public function users()
    {
        return $this->belongsToMany('App\User')->withTimestamps();
    }

    public function committeemembers()
    {
        return $this->hasMany('App\Committeemember');
    }

    public function ocms()
    {
        return $this->hasMany('App\Ocm','targetorg_id');
    }

    public function ocmtitles()
    {
        return $this->hasMany('App\Ocmtitle', 'targetorg_id');
    }

    public function impdates()
    {
        return $this->hasMany('App\Importantdate');
    }

    public function downloads()
    {
        return $this->hasMany('App\Download');
    }

    public function quicklinks()
    {
        return $this->hasMany('App\Quicklink');
    }

    public function cpapers()
    {
        return $this->hasMany('App\Callforpaper');
    }

    public function additionalcontents()
    {
        return $this->hasMany('App\Additionalcontent');
    }

    public function galleries()
    {
        return $this->hasMany('App\Confgallery');
    }

    public function menu()
    {
        return $this->hasMany('App\Menu');
    }

    public function submenus()
    {
        return $this->hasManyThrough('App\Submenu','App\Menu');
    }

    public function regmenus()
    {
        return $this->hasMany('App\Registrationmenu');
    }
}
