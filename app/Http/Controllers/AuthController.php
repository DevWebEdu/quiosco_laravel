<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegistroRequest;

class AuthController extends Controller
{
    public function logout(Request $request ){
        $user = $request -> user();
        $user->currentAccessToken()->delete();

        return [
            'user' => null
        ];
    }

    public function register(RegistroRequest $request){
        // Valida el registro
        $data = $request->validated();

        //Crea el usuario
        $user = User::create(
          ['name' => $data['name'],
        'email' => $data['email'],
        'password' => bcrypt($data['password']) ]  
        );
       
        return [
            'token' => $user->createToken('token')->plainTextToken,
            'user' => $user
        ];

    }

    public function login (LoginRequest $request){

        $data = $request->validated();

        //revisar si el password es igual al que se tiene en la BD
        if(!Auth::attempt($data)){
            return  response([
                'errors' => ['El email o el password son incorrectos']
            ],422);
        };
        //Autenticar al usuario
        $user = Auth::user();

        return [
            'token' => $user->createToken('token')->plainTextToken,
            'user' => $user
        ];
    }   

}

