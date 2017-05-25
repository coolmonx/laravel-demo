<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['event_name', 'event_location', 'event_date', 'event_time', 'event_image', 'event_organizer'];

    public function tickets()
    {
        return $this->hasMany('App\Ticket');
    }
}
