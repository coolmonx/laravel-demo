<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;

use App\Event;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;

class EventController extends Controller
{
    use Helpers;

    public function index()
    {
        $column = ['id','event_name','event_location'];
        return Event::all($column);
    }

    public function show($id)
    {

        $event = Event::find($id);

        if(!$event) {
            //throw new NotFoundHttpException; 
            return response()->json([
                'status' => '404',
                'detail' => 'Event not found.'
                ], 404);
        }

        return $event;
    }
}
