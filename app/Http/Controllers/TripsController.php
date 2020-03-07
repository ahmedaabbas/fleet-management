<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Trip;

class TripsController extends Controller
{
    public function create(Request $request)
    {
        $data = $request->validate(['bus_id' => 'required', 'route' => 'required']);
        $trip = Trip::create([
            'bus_id' => $data['bus_id']
        ]);
        $trip->createRoute($data['route']);
        return $trip;
    }
}
