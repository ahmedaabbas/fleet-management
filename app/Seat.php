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
        $tickets = json_decode($this->tickets, true);
        $departureStation = StationTrip::where([
            ['station_id', '=', $departure],
            ['trip_id', '=', $trip]
        ])->get()->first()['order'];
        $arrivalStation = StationTrip::where([
            ['station_id', '=', $arrival],
            ['trip_id', '=', $trip]
        ])->get()->first()['order'];
        $tripData = Trip::with('stations')->find($trip);
        $departureOrder = 0;
        $arrivalOrder = 0;
        foreach($tripData['stations'] as $station) {
            if($station['route']['station_id'] == $departure) $departureOrder = $station['route']['order'];
            if($station['route']['station_id'] == $arrival) $arrivalOrder = $station['route']['order'];
        }
        if($departureOrder >= $arrivalOrder) {
            return false;
        } else if(!in_array($this->id, array_map(function($ticket) {
            return $ticket['seat_id'];
        }, $tickets))) {
            return true;
        } else if(array_reduce($tickets, function($bool, $ticket) use ($departureStation, $arrivalStation, $trip) {
            $ticketDeparture = StationTrip::where([
                ['station_id', '=', $ticket['departure_station']],
                ['trip_id', '=', $trip]
            ])->get()->first()['order'];
            $ticketArrival = StationTrip::where([
                ['station_id', '=', $ticket['arrival_station']],
                ['trip_id', '=', $trip]
            ])->get()->first()['order'];
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
