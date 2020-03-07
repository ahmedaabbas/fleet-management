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
         return $this->belongsToMany(Trip::class)->withPivot('trip_id', 'order');
    }
}
