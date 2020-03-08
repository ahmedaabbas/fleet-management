<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use App\StationTrip;
class StationTrip extends Pivot
{
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
    public static function stationOrder($station, $trip)
    {
        $stationOrder = StationTrip::where([
            ['station_id', '=', $station],
            ['trip_id', '=', $trip]
        ])->first()['order'];
        return $stationOrder;
    }
}
