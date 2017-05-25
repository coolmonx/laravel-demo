<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;

use App\Ticket;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;

class TicketController extends Controller
{
    use Helpers;

    public function index($event_id)
    {
        $column = ['id','ticket_level','ticket_zone'];
        return Ticket::where('event_id',$event_id)->get($column);
    }

    public function show($event_id, $ticket_id)
    {

        $ticket = Ticket::where('event_id',$event_id)->find($ticket_id);

        if(!$ticket) {            
            //throw new NotFoundHttpException; 
            return response()->json([
                'status' => '404',
                'detail' => 'Ticket not found.'
                ], 404);
        }

        return $ticket;
    }
}
