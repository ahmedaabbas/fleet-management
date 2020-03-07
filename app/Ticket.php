<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Ticket extends Model
{
    protected $fillable = [
            'user_id', 'trip_id', 'seat_id', 'departure_station', 'arrival_station'
        ];
    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }
    public function departureStation()
    {
        return $this->belongsTo(Station::class);
    }
    public function arrivalStation()
    {
        return $this->belongsTo(Station::class);
    }
}
