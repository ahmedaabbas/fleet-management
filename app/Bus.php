<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    protected $fillable = [
        'numbers'
    ];
    public function seats()
    {
        return $this->hasMany(Seat::class);
    }
}
