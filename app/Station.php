<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    protected $fillable = [
        'name'
    ];
    public function trips()
    {
         return $this->belongsToMany('App\Trip', 'stations_trips');
    }
}
