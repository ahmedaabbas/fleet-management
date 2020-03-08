<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Trip;

class TripsController extends Controller
{
    public function create(Request $request)
    {
        if(auth()->user()->can('create', Trip::class)) {
            $data = $request->validate(['bus_id' => 'required', 'route' => 'required']);
            $trip = Trip::create([
                'bus_id' => $data['bus_id']
            ]);
            $trip->createRoute($data['route']);
        }
        return $trip;
    }
    public function viewAny()
    {
        $trips = Trip::get();
        return $trips;
    }
    public function view($id)
    {
        $trip = Trip::find($id);
        return $trip;
    }
    public function update(Request $request)
    {
        if(auth()->user()->can('update', Trip::class)) {
            $data = $request->validate(['route' => 'required', 'bus_id' => 'required']);
            $trip = Trip::find($request['id'])->update($data);
            return $trip;
        }
             return response()->json(['error' => 'you dont have permission to update a trip'], 401);
    }
    public function delete(Request $request)
    {
        if(auth()->user()->can('delete', Trip::class)) {
            $trip = Trip::find($request['id']);
            $trip->delete();
            return $trip;
        }
             return response()->json(['error' => 'you dont have permission to delete a trip'], 401);
    }
}
