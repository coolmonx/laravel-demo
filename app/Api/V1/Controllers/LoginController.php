<?php

namespace App\Api\V1\Controllers;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Tymon\JWTAuth\JWTAuth;
use App\Http\Controllers\Controller;
use App\Api\V1\Requests\LoginRequest;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class LoginController extends Controller
{
    public function login(LoginRequest $request, JWTAuth $JWTAuth)
    {
        $credentials = $request->only(['email', 'password']);

        try {
            $token = $JWTAuth->attempt($credentials);

            if(!$token) {
                return response()->json([
                    'status' => '401',
                    'detail' => 'Invalid Credentials'
                    ], 401);
            }

        } catch (JWTException $e) {
            return response()->json([
                'status' => '500',
                'detail' => 'Internal Server Error'
                ], 500);
        }

        $user = $JWTAuth->parseToken()->authenticate();

        // Token valid; but login email is invalid
        if ($request->email != $user->email) {
            return response()->json([
                'status' => '401',
                'detail' => 'Token does not match login account!'
                ], 401);            
        }

        return response()
            ->json([
                'status' => '200',
                'detail' => 'Login Success',                
                'token' => $token,
                'user_details' => [
                    'id' => $user->id,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'email' => $user->email
                ]
            ]);
    }
}
