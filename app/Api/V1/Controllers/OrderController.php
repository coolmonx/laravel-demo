<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;

use JWTAuth;
use App\Order;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    use Helpers;

    public function purchase(Request $request)
    {
        $currentUser = JWTAuth::parseToken()->authenticate();

        $order = new Order;
        $ticket_id = $request->get('ticket_id');

        if(!$ticket_id) {
            return response()->json([
                'status' => '500',
                'detail' => 'Invalid Ticket ID'
                ], 500);
        }

        $order->ticket_id = $ticket_id;
        $order->status = 0;

        if($currentUser->orders()->save($order)) {
            //return $this->response->created();
            return response()->json([
                    'status' => '200',
                    'detail' => 'Order created.',
                ], 200);
        }
        else {
            //return $this->response->error('could_not_create_order', 500);
            return response()->json([
                    'status' => '500',
                    'detail' => 'Cannot created order.',
                ], 500);
        }
    }


}
