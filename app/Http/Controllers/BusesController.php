<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bus;

class BusesController extends Controller
{
    public function create()
    {
        if(auth()->user()->can('create', Bus::class)) {
            $data = request()->validate(['numbers' => 'required']);
            $bus = Bus::create([
                'numbers' => $data['numbers']
            ]);
            $bus->createSeats();
            return $bus;
        }
        return response()->json(['error' => 'you dont have permission to create a bus'], 401);
    }
    public function viewAny()
    {
        $stations = Bus::get();
        return $stations;
    }
    public function view($id)
    {
        $bus = Bus::find($id);
        return $bus;
    }
    public function update(Request $request)
    {
        if(auth()->user()->can('update', Bus::class)) {
            $data = $request->validate(['numbers' => 'required', 'id' => 'required']);
            $bus = Bus::find($data['id']);
            $bus->numbers = $data['numbers'];
            $bus->save();
            return $bus;
        }
             return response()->json(['error' => 'you dont have permission to update a bus'], 401);
    }
    public function delete(Request $request)
    {
        if(auth()->user()->can('delete', Bus::class)) {
            $bus = Bus::find($request['id']);
            $bus->delete();
            return $bus;
        }
             return response()->json(['error' => 'you dont have permission to delete a bus'], 401);
    }    
}
