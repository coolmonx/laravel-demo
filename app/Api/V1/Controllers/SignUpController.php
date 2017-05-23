<?php

namespace App\Api\V1\Controllers;

use Config;
use App\User;
use Tymon\JWTAuth\JWTAuth;
use App\Http\Controllers\Controller;
use App\Api\V1\Requests\SignUpRequest;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Validator, Input, Redirect; 

class SignUpController extends Controller
{
    public function signUp(SignUpRequest $request, JWTAuth $JWTAuth)
    {
        $user = new User($request->all());
        $input['email'] = $user->email;

        // Must not already exist in the `email` column of `users` table
        $rules = array('email' => 'unique:users,email');
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {

            return response()->json([
                'status' => '500',
                'detail' => 'Email already exists in database.'
            ], 500);

        } else {

            if(!$user->save()) {
                throw new HttpException(500);            
            }        

            if(!Config::get('boilerplate.sign_up.release_token')) {
                return response()->json([
                    'status' => 'ok'
                ], 201);
            }

            $token = $JWTAuth->fromUser($user);
            return response()->json([
                'status' => 'ok',
                'token' => $token
            ], 201);
        }
    }
}
