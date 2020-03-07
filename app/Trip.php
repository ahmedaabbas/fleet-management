<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Station;

class Trip extends Model
{
    protected $fillable = [
        'bus_id'
    ];
    public function bus()
    {
        return $this->hasOne(Bus::class);
    }
    public function stations()
    {
        return $this->belongsToMany(Station::class);
    }
    public function createRoute($route)
    {
        return $this->stations()->attach($route);
    }
}