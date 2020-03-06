<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Station;

class StationsController extends Controller
{
    public function create()
    {
        if(auth()->user()->can('create', Station::class)) {
            $data = request()->validate(['name' => 'required']);
            $station = Station::create([
                'name' => $data['name']
            ]);
            return $station;
        }
             return response()->json(['error' => 'you dont have permission to create a station'], 401);
    }
    public function viewAny()
    {
        $stations = Station::get();
        return $stations;
    }
    public function view($id)
    {
        $station = Station::find($id);
        return $station;
    }
    public function update(Request $request)
    {
        if(auth()->user()->can('update', Station::class)) {
            $data = $request->validate(['name' => 'required', 'id' => 'required']);
            $station = Station::find($data['id']);
            $station->name = $data['name'];
            $station->save();
            return $station;
        }
             return response()->json(['error' => 'you dont have permission to update a station'], 401);
    }
    public function delete(Request $request)
    {
        if(auth()->user()->can('delete', Station::class)) {
            $station = Station::find($request['id']);
            $station->delete();
            return $station;
        }
             return response()->json(['error' => 'you dont have permission to delete a station'], 401);
    }
}
