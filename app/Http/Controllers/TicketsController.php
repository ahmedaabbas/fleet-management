<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Trip;
use App\StationTrip;
use App\Ticket;
use App\Seat;
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
            return $trip->checkRoute($departureStation, $arrivalStation);
        });
        $seats = [];
        foreach($array as $trip) {
            $newSeats = $trip->avaliableSeats($departureStation, $arrivalStation);
            $seats = array_merge($seats, json_decode($newSeats, true));
        }
        return $seats;
    }
    public function bookTicket(Request $request)
    {
        $data = $request->validate([
            'trip_id' => 'required', 
            'seat_id' => 'required', 
            'departure_station' => 'required', 
            'arrival_station' => 'required'
        ]);
        if(!Seat::find($data['seat_id'])->checkSeat($data['departure_station'], $data['arrival_station'], $data['trip_id'])) {
            return response()->json(['error' => 'there is no seats avaliable'], 500);
        }
        $data['user_id'] = auth()->user()->id;
        $ticket = Ticket::create($data);
        return $ticket;
    }
}
