<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(RegisterRequest $request){

        $data = $request->validated();
        
        $user = User::create([
            'first_name' => ucfirst($data['first_name']),
            'last_name' => ucfirst($data['last_name']),
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        $token = Str::random(32);

        return response()->json([
            'success' => true,
            'message' => 'User creeat cu succes',
            'data'      => [
                'user' => [ 
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'email' => $user->email,
                ],
                'token' => $token
                ],    
            ]
        ,Response::HTTP_CREATED);
    }

    public function login(LoginRequest $request){
        
        $credentials = $request->validated();
 
        if (Auth::attempt($credentials)) {

            $token = Str::random(32);
            $user = Auth::user();

            return response()->json([
                'success' => true,
                'message' => 'Login cu succes',
                'data'      => [
                    'user' => [ 
                        'first_name' => $user->first_name,
                        'last_name' => $user->last_name,
                        'email' => $user->email,
                    ],
                    'token' => $token,
                ]
            ],Response::HTTP_OK);

        } 

        return response()->json([
            'success' => false,
            'message' => 'Login esuat, verificati credentialele',
            'data'      => []
        ],Response::HTTP_UNAUTHORIZED);

    }

}
