<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number', 'bus_id'
    ];

    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }
}
