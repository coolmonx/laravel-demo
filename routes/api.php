<?php

use Dingo\Api\Routing\Router;

/** @var Router $api */
$api = app(Router::class);

$api->version('v1', function (Router $api) {
    $api->group(['prefix' => 'v1/auth'], function(Router $api) {
        $api->post('signup', 'App\\Api\\V1\\Controllers\\SignUpController@signUp');
        $api->post('login', 'App\\Api\\V1\\Controllers\\LoginController@login');
        $api->post('recovery', 'App\\Api\\V1\\Controllers\\ForgotPasswordController@sendResetEmail');
        $api->post('reset', 'App\\Api\\V1\\Controllers\\ResetPasswordController@resetPassword');

        $api->get('signup', function() {
            return response()->json([
                'status' => '405',
                'detail' => 'HTTP GET method is not allowed.'
            ], 405);
    });



    });

    $api->group(['middleware' => 'jwt.auth'], function(Router $api) {
        $api->get('protected', function() {
            return response()->json([
                'message' => 'Access to protected resources granted! You are seeing this text as you provided the token correctly.'
            ]);
        });

        $api->get('refresh', [
            'middleware' => 'jwt.refresh',
            function() {
                return response()->json([
                    'message' => 'By accessing this endpoint, you can refresh your access token at each request. Check out this response headers!'
                ]);
            }
        ]);
    });
/*
    $api->get('hello', function() {
        return response()->json([
            'message' => 'This is a simple example of item returned by your APIs. Everyone can see it.'
        ]);
    });
*/
    $api->group(['prefix' => 'v1','middleware' => 'api.auth'], function ($api) {
        $api->get('books', 'App\Api\V1\Controllers\BookController@index');
        $api->get('books/{id}', 'App\Api\V1\Controllers\BookController@show');
        $api->post('books', 'App\Api\V1\Controllers\BookController@store');
        $api->put('books/{id}', 'App\Api\V1\Controllers\BookController@update');
        $api->delete('books/{id}', 'App\Api\V1\Controllers\BookController@destroy');

        // Order
        $api->post('orders', 'App\Api\V1\Controllers\OrderController@purchase');
    });

    $api->group(['prefix' => 'v1'], function(Router $api) {
        // Events
        $api->get('events', 'App\Api\V1\Controllers\EventController@index');
        $api->get('events/{id}', 'App\Api\V1\Controllers\EventController@show');

        // Tickets
        $api->get('events/{event_id}/tickets', 'App\Api\V1\Controllers\TicketController@index');
        $api->get('events/{event_id}/tickets/{ticket_id}', 'App\Api\V1\Controllers\TicketController@show');        
    });

});
