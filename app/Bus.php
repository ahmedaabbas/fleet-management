<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Seat;
class Bus extends Model
{
    protected $fillable = [
        'numbers'
    ];
    public function seats()
    {
        return $this->hasMany(Seat::class);
    }
    public function createSeats()
    {
        return $this->seats()->createMany(array_map(function($number) {
                return ['number' => $number];
            }, range(1,12)));
    }
}
