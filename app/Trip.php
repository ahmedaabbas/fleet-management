<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Station;
use App\StationTrip;
class Trip extends Model
{
    protected $fillable = [
        'bus_id'
    ];
    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }
    public function stations()
    {
        return $this->belongsToMany(Station::class)->using('App\StationTrip')->as('route')->withPivot('station_id', 'order');
    }
    public function createRoute($route)
    {
        return $this->stations()->attach($route);
    }
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function avaliableSeats($departure, $arrival)
    {
        $id = $this->id;
        $departureStation = StationTrip::where([
            ['station_id', '=', $departure],
            ['trip_id', '=', $id]
        ])->get()->first()['order'];
        $arrivalStation = StationTrip::where([
            ['station_id', '=', $arrival],
            ['trip_id', '=', $id]
        ])->get()->first()['order'];
        $seats = $this->bus->seats()->with(['tickets' => function($query) use($id) {
            $query->where('trip_id', $id);
        }])->get();
        return $seats->filter(function($seat) use ($departureStation, $arrivalStation, $id) {
            $tickets = json_decode($seat['tickets'], true);
            if(!in_array($seat['id'], array_map(function($ticket) {
                return $ticket['seat_id'];
            },$tickets))) {
                return true;
            } else if(array_reduce($tickets, function($bool, $ticket) use ($departureStation, $arrivalStation, $id) {
                $ticketDeparture = StationTrip::where([
                    ['station_id', '=', $ticket['departure_station']],
                    ['trip_id', '=', $id]
                ])->get()->first()['order'];
                $ticketArrival = StationTrip::where([
                    ['station_id', '=', $ticket['arrival_station']],
                    ['trip_id', '=', $id]
                ])->get()->first()['order'];
                if(($departureStation < $ticketArrival) && ($arrivalStation > $ticketDeparture)) {
                    return false;
                } else {
                    return $bool;
                }
            }, true)) {
                return true;
            } else {
                return false;
            }
        });
    }
}