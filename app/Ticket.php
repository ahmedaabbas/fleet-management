<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Trip;
class Ticket extends Model
{
    protected $fillable = [
            'user_id', 'trip_id', 'seat_id', 'departure_station', 'arrival_station'
        ];
}
