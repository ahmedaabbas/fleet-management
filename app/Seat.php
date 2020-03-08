<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    protected $fillable = [
        'number', 'bus_id'
    ];

    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
    public function tripTickets($trip)
    {
        return $this->tickets()->where('trip_id', $trip)->get();
    }
    public function checkSeat($departure, $arrival, $trip)
    {
        $tickets = json_decode($this->tripTickets($trip), true);
        $departureStation = StationTrip::where([
            ['station_id', '=', $departure],
            ['trip_id', '=', $trip]
        ])->first()['order'];
        $arrivalStation = StationTrip::where([
            ['station_id', '=', $arrival],
            ['trip_id', '=', $trip]
        ])->first()['order'];
        $tripData = Trip::with('stations')->find($trip);
        if(!$tripData->checkRoute($departure, $arrival)) {
            return false;
        } else if(!in_array($this->id, array_map(function($ticket) {
            return $ticket['seat_id'];
        }, $tickets))) {
            return true;
        } else if(array_reduce($tickets, function($bool, $ticket) use ($departureStation, $arrivalStation, $trip) {
            $ticketDeparture = StationTrip::where([
                ['station_id', '=', $ticket['departure_station']],
                ['trip_id', '=', $trip]
            ])->first()['order'];
            $ticketArrival = StationTrip::where([
                ['station_id', '=', $ticket['arrival_station']],
                ['trip_id', '=', $trip]
            ])->first()['order'];
            if(($departureStation < $ticketArrival) && ($arrivalStation > $ticketDeparture)) {
                return false;
            } else {
                return $bool;
            }        }, true)) {
            return true;
        } else {
            return false;
        }
    }
}
