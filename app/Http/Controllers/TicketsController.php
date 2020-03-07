<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Trip;
use App\StationTrip;
use App\Ticket;
class TicketsController extends Controller
{
    public function lookForTickets($departureStation, $arrivalStation)
    {
        $trips = Trip::with('stations');
        foreach([$departureStation, $arrivalStation] as $station) {
            $trips->whereHas('stations', function($query) use($station) {
                $query->where('station_trip.station_id', $station);
            });
        }
        $array = $trips->get()->filter(function($trip) use ($departureStation, $arrivalStation) {
            $departureOrder = 0;
            $arrivalOrder = 0;
            foreach($trip['stations'] as $station) {
                if($station['route']['station_id'] == $departureStation) $departureOrder = $station['route']['order'];
                if($station['route']['station_id'] == $arrivalStation) $arrivalOrder = $station['route']['order'];
            } 
            return $departureOrder < $arrivalOrder;
        });
        foreach($array as $trip) {
            $seats = $trip->bus()->seats();
            $tickets = $trip->tickets();
        }
        return $array;
    }
    public function bookTicket(Request $request)
    {
        $data = $request->validate([
            'trip_id' => 'required', 
            'seat_id' => 'required', 
            'departure_station' => 'required', 
            'arrival_station' => 'required'
        ]);
        $data['user_id'] = auth()->user()->id;
        $ticket = Ticket::create($data);
        return $ticket;
    }
}
