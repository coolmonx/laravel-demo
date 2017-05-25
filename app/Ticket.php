<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = ['ticket_level', 'ticket_zone', 'ticket_amount', 'ticket_price'];

    public function events()
    {
        return $this->belongsTo('App\Event', 'event_id', 'id');
    }
}
