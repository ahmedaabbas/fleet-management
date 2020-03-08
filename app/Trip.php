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
    public function checkRoute($departureStation, $arrivalStation)
    {
        //checks if a route is in proper order
        $departureOrder = 0;
        $arrivalOrder = 0;
        foreach($this->stations as $station) {
            if($station['route']['station_id'] == $departureStation) $departureOrder = $station['route']['order'];
            if($station['route']['station_id'] == $arrivalStation) $arrivalOrder = $station['route']['order'];
        } 
        return $departureOrder < $arrivalOrder;
    }
    public function avaliableSeats($departure, $arrival)
    {
        $id = $this->id;
        $seats = $this->bus->seats;
        return $seats->filter(function($seat) use ($departure, $arrival, $id) {
            return $seat->checkSeat($departure, $arrival, $id);
        });
    }
}