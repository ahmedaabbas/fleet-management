<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class StationTrip extends Pivot
{
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
