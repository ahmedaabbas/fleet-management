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
        $tripData = Trip::with('stations')->find($trip);
        $departureStation = StationTrip::stationOrder($departure, $trip); 
        $arrivalStation = StationTrip::stationOrder($arrival, $trip);

        if(!$tripData->checkRoute($departure, $arrival)) {
            return false;
        } else if(!in_array($this->id, array_map(function($ticket) {
            return $ticket['seat_id'];
        }, $tickets))) {
            return true;
        } else if(array_reduce($tickets, function($bool, $ticket) use ($departureStation, $arrivalStation, $trip) {
            $ticketDeparture = StationTrip::stationOrder($ticket['departure_station'], $trip);
            $ticketArrival = StationTrip::stationOrder($ticket['arrival_station'], $trip);
            if(($departureStation < $ticketArrival) && ($arrivalStation > $ticketDeparture)) {
                return false;
            } else {
                return $bool;
            }}, true)) {
            return true;
        } else {
            return false;
        }
    }
}
